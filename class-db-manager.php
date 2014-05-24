<?php

class Patient_Db_Manager {
	
	private static $_prefix = 'patient_';
	private $current_patient;
	private $relation_ids = array();
	private $patient_data = array();
	private $date = array();

	private static $datas = array(
		'dates' => array(
			'handler' => 'dates',
			),
		'recovery' => array(
			'handler' => 'recovery',
			),
		'symptoms' => array(
			'handler' => 'symptoms',
			),
		'assays' => array(
			'handler' => 'assays'
			),
		'diagnosis' => array(
			'handler' => 'diagnosis'
			),
		'therapies' => array(
			'handler' => 'therapies'
			),
		'lifestyle' => array(
			'handler' => 'lifestyle'
			)
		);

	public function setPatient($patient) {

		$this->current_patient = $patient;
		return $this;
	}

	public function getPatientData() {
		
		return $this->patient_data;
	}

	public function setPrefix($prefix) {

		self::$_prefix = $prefix;
		return $this;
	}

	public function loadPatientAllData($dates = array()) {
		// $redis = new Predis\Client();
		// $patient_data = $redis->get('patient:id:'.$this->current_patient);

		// if(null != $patient_data) {
		// 	$this->patient_data = json_decode($patient_data);
		// 	return $this;
		// } else {
			if(!empty($dates)) {
				self::$datas['dates']['handler'] = 'bydates';
				$this->dates = $dates;
			}

			foreach (self::$datas as $data) {
				$this->loadPatientSingleData($data['handler']);			
			}
			$this->patient_data = (object) $this->patient_data;
			$datas_json = json_encode($this->patient_data);
			// $redis->set('patient:id:'.$this->current_patient, $datas_json);
			return $this;
		// }
	}

	public function loadPatientSingleData($data_name) {
		if($data_name == 'bydates') {
			$data_name = 'dates';
		}
		$config = self::$datas[$data_name];
		$method_name = '_load'.ucfirst($config['handler']);
		$this->$method_name();
		return $this;
	}

	private function _loadDates() {
		
		global $wpdb;

		$date_sql = 'SELECT * FROM  (SELECT * FROM '.self::$_prefix.'relations R				    
				     WHERE R.user_id ='.$this->current_patient.'
				     ORDER BY R.date DESC LIMIT 6) T ORDER BY T.date ASC';
	
	    $dates = $wpdb->get_results($date_sql);

	    foreach ($dates as $date) {
	    	$this->relation_ids[$date->date] = $date->relation_id;
	    }
	   	
	    $this->patient_data['dates'] = $dates;
	}

	private function _loadBydates() {
		global $wpdb;
		$start = "'".$this->dates['start']."'";
		$end = "'".$this->dates['end']."'";
		$date_sql = 'SELECT * FROM  (SELECT * FROM '.self::$_prefix.'relations R				    
				     WHERE R.user_id ='.$this->current_patient.' AND date >= '.$start.' AND date <= '.$end.' 
				     ORDER BY R.date DESC LIMIT 6) T ORDER BY T.date ASC';
		
	    $dates = $wpdb->get_results($date_sql);

	    foreach ($dates as $date) {
	    	$this->relation_ids[$date->date] = $date->relation_id;
	    }
	        
	    $this->patient_data['dates'] = $dates;
	}

	private function _loadRecovery()  {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);

		$recovery_sql = 'SELECT R.*,RS.recovery_id,RS.remarks,RS.value FROM '.self::$_prefix.'relations R
					     INNER JOIN '.self::$_prefix.'recovery_status RS 
					     ON R.relation_id = RS.relation_id
					     WHERE R.relation_id IN ('.$relation_ids_str.')
						 ORDER BY R.date';

	    $recoverys = $wpdb->get_results($recovery_sql);
	    $recovery_assoc = array();

	    foreach ($recoverys as $recovery) {
	    	$recovery_assoc[$recovery->relation_id] = $recovery;	
	    }

	    foreach ($this->relation_ids as $id) {
	    		    	
	    	if(!array_key_exists($id, $recovery_assoc)) {
	    		$recovery_assoc[$id] = array();
	    	}
	    }

	    $recovery_assoc = $this->customSort($recovery_assoc, $this->relation_ids);

	    $this->patient_data['recovery'] = $recovery_assoc;
	}

	private function _loadSymptoms() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);

		$symptoms_array = array(
			'mental' => array(),
			'sexual' => array(),
			'physical' => array(),
			'hormonal' => array()
		);
		$symptoms_sql = 'SELECT R.relation_id,R.date,US.user_symptom_id,Us.value,US.symptom_id,US.comment,S.name as symptom_name,SC.symptom_category_id FROM '.self::$_prefix.'relations R
						 INNER JOIN '.self::$_prefix.'user_symptoms US
						 ON R.relation_id = US.relation_id
						 INNER JOIN '.self::$_prefix.'symptoms S
						 ON US.symptom_id = S.symptom_id
						 INNER JOIN '.self::$_prefix.'symptoms_category SC
						 ON S.symptom_category_id = SC.symptom_category_id
						 WHERE R.relation_id IN ('.$relation_ids_str.')
						 ORDER BY R.date';
		
		$symptoms = $wpdb->get_results($symptoms_sql);

		foreach ($symptoms as $symptom) {
			switch ($symptom->symptom_category_id) {
				case '1':
					$symptoms_array['mental'][$symptom->relation_id] = $symptom;
					break;
				case '2':
					$symptoms_array['sexual'][$symptom->relation_id] = $symptom;
					break;
				case '3':
					$symptoms_array['physical'][$symptom->relation_id] = $symptom;
					break;
				case '4':
					$symptoms_array['hormonal'][$symptom->relation_id] = $symptom;
					break;
			}
		}

		foreach ($symptoms_array as $type => $symptom) {
			
			foreach ($this->relation_ids as $id) {	    		    	
		    	if(!array_key_exists($id, $symptom)) {		    		
		    		$symptom[$id] = array();
		    	}		    	
		    }
		    $symptom = $this->customSort($symptom, $this->relation_ids);
		    $symptoms_array[$type] = $symptom;

		}
		
		$this->patient_data['symptoms'] = $symptoms_array;

	}

	private function _loadAssays() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);

		$assays_sql = 'SELECT R.date,R.user_id,AR.*,A.name as assay_name,A.submit_date,A.comment,A.approved,AC.* FROM '.self::$_prefix.'relations R
					   INNER JOIN '.self::$_prefix.'assay_result AR 
					   ON R.relation_id = AR.relation_id
					   INNER JOIN '.self::$_prefix.'assays A
					   ON AR.assay_id = A.assay_id
					   INNER JOIN '.self::$_prefix.'assay_category AC
					   ON A.assay_category_id = AC.assay_category_id
					   WHERE R.relation_id IN ('.$relation_ids_str.')
					   ORDER BY R.date';
					   
	    $assays = $wpdb->get_results($assays_sql);

	    $assay_assoc = array();

	    foreach ($assays as $assay) {
	    	$assay_assoc[$assay->relation_id] = $assay;	
	    }

	    foreach ($this->relation_ids as $id) {
	    		    	
	    	if(!array_key_exists($id, $assay_assoc)) {
	    		$assay_assoc[$id] = array();
	    	}
	    }

	    $assay_assoc = $this->customSort($assay_assoc, $this->relation_ids);

	    $this->patient_data['assays'] = $assay_assoc;
	}

	private function _loadDiagnosis() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);

		$diagnosis_sql = 'SELECT R.date,R.user_id,DD.*,D.name,D.submit_date,D.comment as diagnos_comment,D.approved,DOC.name as doc_name,DOC.city,DOC.country,DOC.submit_date as doc_submit_date,DOC.comment as doc_comment,DOC.approved as doc_approved FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'doctor_diagnosis DD
						  ON R.relation_id = DD.relation_id
						  INNER JOIN '.self::$_prefix.'diagnosis D
						  ON DD.diagnosis_id = D.diagnosis_id
						  INNER JOIN '.self::$_prefix.'doctors DOC
						  ON DD.doctor_id = DOC.doctor_id
						  WHERE R.relation_id IN ('.$relation_ids_str.')
					   	  ORDER BY R.date';
					   	  
		$diagnosis = $wpdb->get_results($diagnosis_sql);

		$diagnos_assoc = array();

	    foreach ($diagnosis as $diagnos) {
	    	$diagnos_assoc[$diagnos->relation_id] = $diagnos;	
	    }

	    foreach ($this->relation_ids as $id) {
	    		    	
	    	if(!array_key_exists($id, $diagnos_assoc)) {
	    		$diagnos_assoc[$id] = array();
	    	}
	    }

	    $diagnos_assoc = $this->customSort($diagnos_assoc, $this->relation_ids);

		$this->patient_data['diagnosis'] = $diagnos_assoc;
	}

	private function _loadTherapies() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);
		$therapies_sql = 'SELECT R.date,R.user_id,TR.*,T.therapy_category_id,T.name,T.comment as admin_comment,TC.name as therapy_name FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'therapy_result TR
						  ON R.relation_id = TR.relation_id
						  INNER JOIN '.self::$_prefix.'therapy T
						  ON TR.therapy_id = T.therapy_id
						  INNER JOIN '.self::$_prefix.'therapy_category TC
						  ON T.therapy_category_id = TC.therapy_category_id
						  WHERE R.relation_id IN ('.$relation_ids_str.')
					   	  ORDER BY R.date';

		$therapies = $wpdb->get_results($therapies_sql);

		$therapy_assoc = array();

	    foreach ($therapies as $therapy) {
	    	$therapy_assoc[$therapy->relation_id] = $therapy;	
	    }

	    foreach ($this->relation_ids as $id) {
	    		    	
	    	if(!array_key_exists($id, $therapy_assoc)) {
	    		$therapy_assoc[$id] = array();
	    	}
	    }

	    $therapy_assoc = $this->customSort($therapy_assoc, $this->relation_ids);

		$this->patient_data['therapies'] = $therapy_assoc;

	}

	private function _loadLifestyle() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);

		$lifestyle_sql = 'SELECT R.date,R.user_id,LR.*,L.lifestyle_category_id as category_id,L.submit_date,L.name as admin_comment,L.approved,LF.frequency,LF.quantity,LF.name as frequency_name,LC.name as category_name FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'lifestyle_result LR
						  ON R.relation_id = LR.relation_id
						  INNER JOIN '.self::$_prefix.'lifestyle L
						  ON LR.lifestyle_id = L.lifestyle_id
						  INNER JOIN '.self::$_prefix.'lifestyle_frequency LF
						  ON LR.lifestyle_frequency_id = LF.lifestyle_frequency_id
						  INNER JOIN '.self::$_prefix.'lifestyle_category LC
						  ON L.lifestyle_category_id = LC.lifestyle_category_id
						  WHERE R.relation_id IN ('.$relation_ids_str.')
					   	  ORDER BY R.date';
					   	  
		$lifestyles = $wpdb->get_results($lifestyle_sql);

		$lifestyle_assoc = array();

	    foreach ($lifestyles as $lifestyle) {
	    	$lifestyle_assoc[$lifestyle->relation_id] = $lifestyle;	
	    }

	    foreach ($this->relation_ids as $id) {
	    		    	
	    	if(!array_key_exists($id, $lifestyle_assoc)) {
	    		$lifestyle_assoc[$id] = array();
	    	}
	    }

	    $lifestyle_assoc = $this->customSort($lifestyle_assoc, $this->relation_ids);

		$this->patient_data['lifestyle'] = $lifestyle_assoc;
	}

	private function customSort(Array $array, Array $orderArray) {
	    $ordered = array();
	    foreach($orderArray as $key) {
	        if(array_key_exists($key,$array)) {
	            $ordered[$key] = $array[$key];
	            unset($array[$key]);
	        }
	    }
	    return $ordered + $array;
	}

	//write magic functions __get and __set
}

?>
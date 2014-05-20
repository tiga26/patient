<?php

class Patient_Db_Manager {
	
	private static $_prefix = 'patient_';
	private $current_patient;

	private $patient_data = array();

	private static $datas = array(
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

	public function loadPatientAllData() {
		// $redis = new Predis\Client();
		// $patient_data = $redis->get('patient:id:'.$this->current_patient);

		// if(null != $patient_data) {
		// 	$this->patient_data = json_decode($patient_data);
		// 	return $this;
		// } else {

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

		$config = self::$datas[$data_name];
		$method_name = '_load'.ucfirst($config['handler']);
		$this->$method_name();
		return $this;
	}

	private function _loadSymptoms() {
		global $wpdb;

		$symptoms_sql = 'SELECT * FROM '.self::$_prefix.'relations R
						 INNER JOIN '.self::$_prefix.'user_symptoms US
						 ON R.relation_id = US.relation_id
						 INNER JOIN '.self::$_prefix.'symptoms S
						 ON US.symptom_id = S.symptom_id
						 INNER JOIN '.self::$_prefix.'symptoms_category SC
						 ON S.symptom_category_id = SC.symptom_category_id
						 WHERE R.user_id ='.$this->current_patient;
		$symptoms = $wpdb->get_results($symptoms_sql);
		$this->patient_data['symptoms'] = $symptoms;

	}

	private function _loadAssays() {
		global $wpdb;

		$assays_sql = 'SELECT * FROM '.self::$_prefix.'relations R
					   INNER JOIN '.self::$_prefix.'assay_result AR 
					   ON R.relation_id = UA.relation.id
					   INNER JOIN '.self::$_prefix.'assays A
					   ON AR.assay_id A.assay_id
					   INNER JOIN '.self::$_prefix.'assay_category AC
					   ON A.assay_category_id = AC.assay_category_id
					   WHERE R.user_id ='.$this->current_patient;
	    $assays = $wpdb->get_results($assays_sql);

	    $this->patient_data['assays'] = $assays;
	}

	private function _loadDiagnosis() {
		global $wpdb;

		$diagnosis_sql = 'SELECT * FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'doctor_diagnosis DD
						  ON R.relation_id = DD.relation_id
						  INNER JOIN '.self::$_prefix.'diagnosis D
						  ON DD.diagnosis_id = D.diagnosis_id
						  INNER JOIN '.self::$_prefix.'doctors DOC
						  ON DD.doctor_id = DOC.doctor_id
						  WHERE R.user_id ='.$this->current_patient;
		$diagnosis = $wpdb->get_results($diagnosis_sql);

		$this->patient_data['diagnosis'] = $diagnosis;
	}

	private function _loadTherapies() {
		global $wpdb;

		$therapies_sql = 'SELECT * FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'therapy_result TR
						  ON R.relation_id = TR.relation_id
						  INNER JOIN '.self::$_prefix.'therapy T
						  ON TR.therapy_id = T.therapy_id
						  INNER JOIN '.self::$_prefix.'therapy_category TC
						  ON T.therapy_category_id = TC.therapy_category_id
						  WHERE R.user_id ='.$this->current_patient;
		$therapies = $wpdb->get_results($therapies_sql);

		$this->patient_data['therapies'] = $therapies;

	}

	private function _loadLifestyle() {
		global $wpdb;

		$lifestyle_sql = 'SELECT * FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'lifestyle_result LR
						  ON R.relation_id = LR.relation_id
						  INNER JOIN '.self::$_prefix.'lifestyle L
						  ON LR.lifestyle_id = L.lifestyle_id
						  INNER JOIN '.self::$_prefix.'lifestyle_frequency LF
						  ON LR.lifestyle_frequency_id = LF.lifestyle_frequency_id
						  INNER JOIN '.self::$_prefix.'lifestyle_category LC
						  ON L.lifestyle_category_id = LC.lifestyle_category_id
						  WHERE R.user_id ='.$this->current_patient.' ORDER BY R.date ASC';
		$lifestyle = $wpdb->get_results($lifestyle_sql);

		$this->patient_data['lifestyle'] = $lifestyle;
	}

	//write magic functions __get and __set
}

?>
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
			),
		'effects' => array(
			'handler' => 'effects'
			),
		'doctors' => array(
			'handler' => 'doctors'
			),
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
	    $dates_array = array();
	    if(count($dates) < 6) {
	    	$max_id_sql = 'SELECT relation_id FROM '.self::$_prefix.'relations ORDER BY relation_id DESC LIMIT 1';
	    	$max_id_array = $wpdb->get_results($max_id_sql);
	    	$max_id = $max_id_array[0]->relation_id;
	    }

	    foreach ($dates as $date) {
	    	$this->relation_ids[$date->date] = $date->relation_id;
	    	$dates_array[$date->relation_id] = $date;
	    }

	    if(count($dates) < 6) {
	    	$more_relations_cnt = 6 - count($dates);
	    	
	    	for ($i = 1; $i <= $more_relations_cnt; $i++) { 
	    		$this->relation_ids[] = $max_id + $i * 1000;
	    	}
	    }


	    $this->patient_data['dates'] = $dates_array;
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
					if(!array_key_exists($symptom->symptom_id,$symptoms_array['mental'])) {
						$symptoms_array['mental'][$symptom->symptom_id] = array();
						array_push($symptoms_array['mental'][$symptom->symptom_id], $symptom);
					} else {
						array_push($symptoms_array['mental'][$symptom->symptom_id], $symptom);
					}					
					break;
				case '2':
					if(!array_key_exists($symptom->symptom_id,$symptoms_array['sexual'])) {
						$symptoms_array['sexual'][$symptom->symptom_id] = array();
						array_push($symptoms_array['sexual'][$symptom->symptom_id], $symptom);
					} else {
						array_push($symptoms_array['sexual'][$symptom->symptom_id], $symptom);
					}
					break;
				case '3':
					if(!array_key_exists($symptom->symptom_id,$symptoms_array['physical'])) {
						$symptoms_array['physical'][$symptom->symptom_id] = array();
						array_push($symptoms_array['physical'][$symptom->symptom_id], $symptom);
					} else {
						array_push($symptoms_array['physical'][$symptom->symptom_id], $symptom);
					}
					break;
				case '4':
					if(!array_key_exists($symptom->symptom_id,$symptoms_array['hormonal'])) {
						$symptoms_array['hormonal'][$symptom->symptom_id] = array();
						array_push($symptoms_array['hormonal'][$symptom->symptom_id], $symptom);
					} else {
						array_push($symptoms_array['hormonal'][$symptom->symptom_id], $symptom);
					}
					break;
			}
		}
		foreach ($symptoms_array as $category => $bytype) {
			foreach ($bytype as $symptom) {
				foreach ($symptom as $key => $value) {
					$tmp_value = $value;
					unset($symptoms_array[$category][$value->symptom_id][$key]);
					$symptoms_array[$category][$value->symptom_id][$tmp_value->relation_id] = $tmp_value;
				}
			}
		}

		foreach ($symptoms_array as $category => $bytype) {
			foreach ($bytype as $key => $symptom) {
				foreach ($this->relation_ids as $id) {	
			    	if(!array_key_exists($id, $symptom)) {		    		
			    		$symptom[$id] = array();
			    	}		    	
			    }
			    $symptom = $this->customSort($symptom, $this->relation_ids);
			    $symptoms_array[$category][$key] = $symptom;
			}
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
	    	if(!array_key_exists($assay->assay_id,$assay_assoc)) {
				$assay_assoc[$assay->assay_id] = array();
				array_push($assay_assoc[$assay->assay_id], $assay);
			} else {
				array_push($assay_assoc[$assay->assay_id], $assay);
			}	    	
	    }
	  	
	  	foreach ($assay_assoc as $assay_id => $assay) {
	  		foreach ($assay as $key => $value) {
	  			$tmp_value = $value;
				unset($assay_assoc[$assay_id][$key]);
				$assay_assoc[$assay_id][$tmp_value->relation_id] = $tmp_value;
	  		}
	  	}

	  	foreach ($assay_assoc as $assay_id => $assay) {
	  		foreach ($this->relation_ids as $id) {		    		    	
		    	if(!array_key_exists($id, $assay)) {		    		
		    		$assay_assoc[$assay_id][$id] = array();
		    	}
		    }
		    $assay_assoc[$assay_id] = $this->customSort($assay_assoc[$assay_id], $this->relation_ids);
	  	}	    

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
	    	if(!array_key_exists($diagnos->diagnosis_id,$diagnos_assoc)) {
				$diagnos_assoc[$diagnos->diagnosis_id] = array();
				array_push($diagnos_assoc[$diagnos->diagnosis_id], $diagnos);
			} else {
				array_push($diagnos_assoc[$diagnos->diagnosis_id], $diagnos);
			}	    	
	    }
	  	
	  	foreach ($diagnos_assoc as $diagnosis_id => $diagnos) {
	  		foreach ($diagnos as $key => $value) {
	  			$tmp_value = $value;
				unset($diagnos_assoc[$diagnosis_id][$key]);
				$diagnos_assoc[$diagnosis_id][$tmp_value->relation_id] = $tmp_value;
	  		}
	  	}

	  	foreach ($diagnos_assoc as $diagnosis_id => $diagnos) {
	  		foreach ($this->relation_ids as $id) {		    		    	
		    	if(!array_key_exists($id, $diagnos)) {		    		
		    		$diagnos_assoc[$diagnosis_id][$id] = array();
		    	}
		    }
		    $diagnos_assoc[$diagnosis_id] = $this->customSort($diagnos_assoc[$diagnosis_id], $this->relation_ids);
	  	}

		$this->patient_data['diagnosis'] = $diagnos_assoc;
	}

	private function _loadTherapies() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);
		$therapies_sql = 'SELECT R.date,R.user_id,TR.*,T.therapy_category_id,T.name,T.comment as admin_comment,TC.name as therapy_name,D.name as doc_name,D.city,D.country FROM '.self::$_prefix.'relations R
						  INNER JOIN '.self::$_prefix.'therapy_result TR
						  ON R.relation_id = TR.relation_id
						  INNER JOIN '.self::$_prefix.'therapy T
						  ON TR.therapy_id = T.therapy_id
						  INNER JOIN '.self::$_prefix.'therapy_category TC
						  ON T.therapy_category_id = TC.therapy_category_id
						  INNER JOIN '.self::$_prefix.'doctors D
						  ON TR.doctor_id = D.doctor_id
						  WHERE R.relation_id IN ('.$relation_ids_str.')
					   	  ORDER BY R.date';

		$therapies = $wpdb->get_results($therapies_sql);

		$therapy_assoc = array();

		foreach ($therapies as $therapy) {
	    	if(!array_key_exists($therapy->therapy_id,$therapy_assoc)) {
				$therapy_assoc[$therapy->therapy_id] = array();
				array_push($therapy_assoc[$therapy->therapy_id], $therapy);
			} else {
				array_push($therapy_assoc[$therapy->therapy_id], $therapy);
			}	    	
	    }
	  	
	  	foreach ($therapy_assoc as $therapy_id => $therapy) {
	  		foreach ($therapy as $key => $value) {
	  			$tmp_value = $value;
				unset($therapy_assoc[$therapy_id][$key]);
				$therapy_assoc[$therapy_id][$tmp_value->relation_id] = $tmp_value;
	  		}
	  	}
	  	
	  	foreach ($therapy_assoc as $therapy_id => $therapy) {
	  		foreach ($this->relation_ids as $id) {		    		    	
		    	if(!array_key_exists($id, $therapy)) {		    		
		    		$therapy_assoc[$therapy_id][$id] = array();
		    	}
		    }
		    $therapy_assoc[$therapy_id] = $this->customSort($therapy_assoc[$therapy_id], $this->relation_ids);
	  	}

		$this->patient_data['therapies'] = $therapy_assoc;

	}

	private function _loadLifestyle() {
		global $wpdb;

		$relation_ids_str = implode(',', $this->relation_ids);

		$lifestyle_sql = 'SELECT R.date,R.user_id,LR.*,L.lifestyle_category_id as category_id,L.submit_date,L.name,L.approved,LF.frequency,LF.quantity,LF.name as frequency_name,LC.name as category_name FROM '.self::$_prefix.'relations R
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
	    	if(!array_key_exists($lifestyle->lifestyle_id,$lifestyle_assoc)) {
				$lifestyle_assoc[$lifestyle->lifestyle_id] = array();
				array_push($lifestyle_assoc[$lifestyle->lifestyle_id], $lifestyle);
			} else {
				array_push($lifestyle_assoc[$lifestyle->lifestyle_id], $lifestyle);
			}	    	
	    }
	  	
	  	foreach ($lifestyle_assoc as $lifestyle_id => $lifestyle) {
	  		foreach ($lifestyle as $key => $value) {
	  			$tmp_value = $value;
				unset($lifestyle_assoc[$lifestyle_id][$key]);
				$lifestyle_assoc[$lifestyle_id][$tmp_value->relation_id] = $tmp_value;
	  		}
	  	}
	  	
	  	foreach ($lifestyle_assoc as $lifestyle_id => $lifestyle) {
	  		foreach ($this->relation_ids as $id) {		    		    	
		    	if(!array_key_exists($id, $lifestyle)) {		    		
		    		$lifestyle_assoc[$lifestyle_id][$id] = array();
		    	}
		    }
		    $lifestyle_assoc[$lifestyle_id] = $this->customSort($lifestyle_assoc[$lifestyle_id], $this->relation_ids);
	  	}	  	

		$this->patient_data['lifestyle'] = $lifestyle_assoc;
	}

	private function _loadEffects() {
		global $wpdb;

		$therapies_array = array();
		$lifestyle_array = array();

		$effects_array = array(
			'therapy' => array(),
			'lifestyle' => array(),
		);

		foreach ($this->patient_data['therapies'] as $therapie_id => $therapies) {
			foreach ($therapies as $relation_id => $therapie) {
				if(!empty($therapie)){
					array_push($therapies_array,$therapie->therapy_result_id);
				}				
			}		
		}

		foreach ($this->patient_data['lifestyle'] as $lifestyle_id => $lifestyles) {
			foreach ($lifestyles as $relation_id => $lifestyle) {
				if(!empty($lifestyle)) {
					array_push($lifestyle_array,$lifestyle->lifestyle_result_id);
				}				
			}		
		}

		if(!empty($therapies_array)) {
			$therapies_str = implode(',', $therapies_array);
			$ther = "'".'therapie'."'";				
			$effect_therapies_sql = 'SELECT E.*,S.symptom_id,S.name FROM '.self::$_prefix.'effect as E
									 INNER JOIN '.self::$_prefix.'user_symptoms US
									 ON E.user_symptom_id = US.user_symptom_id
									 INNER JOIN '.self::$_prefix.'symptoms S
									 ON US.symptom_id = S.symptom_id
									 WHERE E.efficient_id IN ('.$therapies_str.') AND E.type = '.$ther.'';
			$effect_therapies = $wpdb->get_results($effect_therapies_sql);
			foreach ($effect_therapies as $effect) {
				if(!isset($effects_array['therapy'][$effect->efficient_id])) {
					$effects_array['therapy'][$effect->efficient_id] = array();
					array_push($effects_array['therapy'][$effect->efficient_id], $effect);
				} else {
					array_push($effects_array['therapy'][$effect->efficient_id], $effect);
				}				
			}
		}

		if(!empty($lifestyle_array)) {
			$lifestyle_str = implode(',', $lifestyle_array);
			$lifestyle = "'".'lifestyle'."'";
			$effect_lifestyle_sql = 'SELECT E.*,S.symptom_id,S.name FROM '.self::$_prefix.'effect as E
									 INNER JOIN '.self::$_prefix.'user_symptoms US
									 ON E.user_symptom_id = US.user_symptom_id
									 INNER JOIN '.self::$_prefix.'symptoms S
									 ON US.symptom_id = S.symptom_id
									 WHERE E.efficient_id IN ('.$lifestyle_str.') AND E.type = '.$lifestyle.'';
			$effect_lifestyle = $wpdb->get_results($effect_lifestyle_sql);
			foreach ($effect_lifestyle as $effect) {
				if(!isset($effects_array['lifestyle'][$effect->efficient_id])) {
					$effects_array['lifestyle'][$effect->efficient_id] = array();
					array_push($effects_array['lifestyle'][$effect->efficient_id], $effect);
				} else {
					array_push($effects_array['lifestyle'][$effect->efficient_id], $effect);
				}	
			}
		}
		
		$this->patient_data['effects'] = $effects_array;

	}

	private function _loadDoctors() {
		global $wpdb;
		
		$doctors_sql = 'SELECT * FROM '.self::$_prefix.'doctors ';
		$this->patient_data['doctors'] =  $wpdb->get_results($doctors_sql);

		$country_sql = 'SELECT * FROM '.self::$_prefix.'doctors GROUP BY country';
		$this->patient_data['country'] =  $wpdb->get_results($country_sql);

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
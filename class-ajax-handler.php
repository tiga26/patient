<?php
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ). '/wp-load.php' );
require_once('class-db-manager.php');

$ajax = new Patient_Ajax_Handler();
$ajax->init($_POST);

class Patient_Ajax_Handler{
	
	private static $patient_id = 1;
	private static $table;
	private static $patient_data;
	private static $action_type;
	private static $action;
	// private static $patient;
	private static $status_code = array(
		0 => array(
			'status' => '0',
			'message' => 'Nothing has been changed',
		),
		1 => array(			
			'status' => '1',
			'message' => 'The data is inserted successfully',			
		),
		2 => array(			
			'status' => '2',
			'message' => 'The data is successfully updated',			
		),
		3 => array(
			'status' => '3',
			'message' => 'Something gone wrong',
		),
		4 => array(
			'status' => '4',
			'message' => array(),
			'fields' => array(),
		)
	);

	private static $error_message = array(
		'recovery' => array(
			'value' => 'The value of recovery status must be 0%-100%',
		),
		'assays' => array(
			'result' => 'The result field must be above 0',
			'ref_low' => 'Please enter range from 0 - 100%',
			'ref_hi' => 'Please enter range from 0 - 100%',
		),
		'diagnoses' => array(
			'doctor_id' => 'Please choose doctor',
		),
	);

	private static $type_to_table = array(
		'set' => array(
			'recovery' => 'patient_recovery_status',
			'symptom' => 'patient_user_symptoms',
			'assays' => 'patient_assay_result',
			'diagnoses' => 'patient_doctor_diagnosis',
			'therapies' => 'patient_therapy_result',
			'lifestyle' => 'patient_lifestyle_result',	
		),
		'add' => array(
			'symptom' => 'patient_symptoms',
			'assays' => 'patient_assays',
			'diagnoses' => 'patient_diagnosis',
			'therapies' => 'patient_therapy',
			'lifestyle' => 'patient_lifestyle',
			'doctor' => 'patient_doctors',
			'unit' => 'patient_units',
			'date' => 'patient_relations',
		),
		'get' => array(
			'doctor' => 'patient_doctors',
		),
		'delete' => array(
			'recovery' => 'patient_recovery_status',
			'symptom' => 'patient_user_symptoms',
			'assays' => 'patient_assay_result',
			'diagnoses' => 'patient_doctor_diagnosis',
			'therapies' => 'patient_therapy_result',
			'lifestyle' => 'patient_lifestyle_result',	
		),
		
	);

	private static $type_to_id = array(

	);

	public function init($data) {
		
		self::$action = $action_name = $data['action'];
		$action_type = $data['type'];
		self::$patient_data = $data['data'];
		self::$table = self::$type_to_table[$action_type][$action_name];

		if($action_type == 'add') {
			self::$patient_data['submit_date'] = date('Y-m-d H:i:s');
			self::$patient_data['approved'] = 0;
		}

		// $this->checkUserOnDataUpdate();

		add_action('wp_ajax_'.$action_name, array( 'Patient_Ajax_Handler', '_'.$action_type.ucfirst($action_name) ) );
		do_action('wp_ajax_'.$action_name);
	}

	public static function _getSymptoms() {
		global $wpdb;
		$symptom_sql = 'SELECT * FROM '.self::$table.' WHERE user_symptom_id = '.self::$patient_data['id'];
		$symptom = $wpdb->get_results($symptom_sql);
		var_dump($symptom);
	}

	public static function _getAssays() {
		global $wpdb;
		$assay_sql = 'SELECT * FROM '.self::$table.' WHERE assay_result_id = '.self::$patient_data['id'];
		$assay = $wpdb->get_results($assay_sql);
		var_dump($assay);
	}

	public static function _getDiagnoses() {
		global $wpdb;
		$diagnos_sql = 'SELECT * FROM '.self::$table.' WHERE diagnosis_id = '.self::$patient_data['id'];
		$diagnos = $wpdb->get_results($diagnos_sql);		
	}

	public static function _getTherapies() {
		global $wpdb;
		$therapy_sql = 'SELECT * FROM '.self::$table.' WHERE therapy_result_id = '.self::$patient_data['id'];
		$therapy = $wpdb->get_results($therapy_sql);	
	}

	public static function _getLifestyle() {
		global $wpdb;
		$lifestyle_sql = 'SELECT * FROM '.self::$table.' WHERE lifestyle_result_id = '.self::$patient_data['id'];
		$lifestyle = $wpdb->get_results($lifestyle_sql);	
	}

	public static function _getDoctor() {
		global $wpdb;
		$country = "'%".self::$patient_data['country']."%'";
		$doctors_sql = 'SELECT * FROM '.self::$table.' WHERE country LIKE ('.$country.')';
		$doctors = $wpdb->get_results($doctors_sql);
		print_r(json_encode($doctors));
	}

	public static function _setRecovery() {
		global $wpdb;
		$relation_id = "'".self::$patient_data['relation_id']."'";
		$value = "'".self::$patient_data['value']."'";
		$remarks = "'".self::$patient_data['remarks']."'";

		if(null != self::$patient_data['recovery_id']) {
			$recovery_id = "'".self::$patient_data['recovery_id']."'";
			$insert_recovery_sql = 'UPDATE '.self::$table.'
									SET value = '.$value.',
									remarks = '.$remarks.'
									WHERE recovery_id='.$recovery_id;
			$status = 2;
		} else {
			$insert_recovery_sql = 'INSERT INTO '.self::$table.' (relation_id,value,remarks)
									VALUES('.$relation_id.','.$value.','.$remarks.')';
			$status = 1;
		}

		$recovery = $wpdb->query( $insert_recovery_sql );
		if($recovery === false) {
			$status = 3;
		} elseif($recovery == 0) {
			$status = 0;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _setSymptom() {
		global $wpdb;
		$relation_id = "'".self::$patient_data['relation_id']."'";
		$value = "'".self::$patient_data['value']."'";
		$symptom_id = "'".self::$patient_data['symptom_id']."'";
		$comment = "'".self::$patient_data['comment']."'";

		if(null != self::$patient_data['user_symptom_id']) {
			$user_symptom_id = "'".self::$patient_data['user_symptom_id']."'";
			$insert_symptom_sql = 'UPDATE '.self::$table.'
									SET value = '.$value.',
									comment = '.$comment.'
									WHERE user_symptom_id='.$user_symptom_id;
			$status = 2;
		} else {
			$insert_symptom_sql = 'INSERT INTO '.self::$table.' (relation_id,value,symptom_id,comment)
									VALUES('.$relation_id.','.$value.','.$symptom_id.','.$comment.')';
			$status = 1;
		}
		
		$symptom = $wpdb->query( $insert_symptom_sql );
		if($symptom === false) {
			$status = 3;
		} elseif($symptom == 0) {
			$status = 0;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _setAssays() {
		global $wpdb;
		$validate = false;
		if(!is_numeric(self::$patient_data['result'])) {
			array_push(self::$status_code[4]['message'], self::$error_message[self::$action]['result']);
			array_push(self::$status_code[4]['fields'], 'result');
			$validate = true;
		}
		if(!is_numeric(self::$patient_data['ref_low']) || (int)self::$patient_data['ref_low'] < 0 || (int)self::$patient_data['ref_low'] > 100) {			
			array_push(self::$status_code[4]['message'], self::$error_message[self::$action]['ref_low']);
			array_push(self::$status_code[4]['fields'], 'ref_low');
			$validate = true;
		}
		if(!is_numeric(self::$patient_data['ref_hi']) || (int)self::$patient_data['ref_hi'] < 0 || (int)self::$patient_data['ref_hi'] > 100) {
			array_push(self::$status_code[4]['message'], self::$error_message[self::$action]['ref_hi']);
			array_push(self::$status_code[4]['fields'], 'ref_hi');
			$validate = true;
		}

		if($validate) {
			print_r(json_encode(self::$status_code[4]));
			return;
		}

		self::$patient_data['ref_percent'] = (self::$patient_data['result'] - self::$patient_data['ref_low']) / (self::$patient_data['ref_hi'] - self::$patient_data['ref_low']);
		self::$patient_data['remarks'] = "'".self::$patient_data['remarks']."'";
		
		$assay_data_str = implode(',', self::$patient_data);
		
		$insert_assay_sql = 'INSERT INTO '.self::$table.'
		 					(assay_id,relation_id,unit_id,result,ref_low,ref_hi,remarks,ref_percent)
		 					VALUES('.$assay_data_str.') ON DUPLICATE KEY UPDATE
		 					unit_id = '.self::$patient_data['unit_id'].',
		 					result = '.(float)self::$patient_data['result'].',
		 					ref_low = '.(float)self::$patient_data['ref_low'].',
		 					ref_hi = '.(float)self::$patient_data['ref_hi'].',
		 					ref_percent = '.self::$patient_data['ref_percent'].',
		 					remarks = '.self::$patient_data['remarks'].'';

		$assay = $wpdb->query( $insert_assay_sql );
		print_r(json_encode(self::$status_code[$assay]));
	}

	public static function _setDiagnoses() {
		global $wpdb;
		$validate = false;

		if(!isset( self::$patient_data['doctor_id'])) {
			array_push(self::$status_code[4]['message'], self::$error_message[self::$action]['doctor_id']);
			array_push(self::$status_code[4]['fields'], 'doctor_id');
			$validate = true;
		}
		
		if($validate) {
			print_r(json_encode(self::$status_code[4]));
			return;
		}

		self::$patient_data['comment'] = "'".self::$patient_data['comment']."'";
		$diagnosis_data_str = implode(',', self::$patient_data);
		$insert_diagnosis_sql = 'INSERT INTO '.self::$table.'
			 					(diagnosis_id,relation_id,doctor_id,comment)
			 					VALUES('.$diagnosis_data_str.') ON DUPLICATE KEY UPDATE
			 					diagnosis_id = '.self::$patient_data['diagnosis_id'].',
			 					doctor_id = '.self::$patient_data['doctor_id'].',
			 					comment = '.self::$patient_data['comment'].'';
		$diagnosis = $wpdb->query( $insert_diagnosis_sql );
		print_r(json_encode(self::$status_code[$diagnosis]));
	}

	public static function _setTherapies() {
		global $wpdb;

		$relation_id = "'".self::$patient_data['relation_id']."'";
		$dosage = "'".self::$patient_data['dosage']."'";
		$frequency = "'".self::$patient_data['frequency']."'";
		$therapy_id = "'".self::$patient_data['therapy_id']."'";
		$comment = "'".self::$patient_data['comment']."'";
		$self_prescribed = "'".self::$patient_data['self_prescribed']."'";
		$doctor_id = self::$patient_data['doctor_id'];
		$effect = self::$patient_data['effect'];

		if(null != self::$patient_data['therapy_result_id']) {
			$efficient = $therapy_result_id = self::$patient_data['therapy_result_id'];
			$insert_therapy_sql = 'UPDATE '.self::$table.'
									SET dosage = '.$dosage.',
									frequency = '.$frequency.',
									self_prescribed = '.$self_prescribed.',
									doctor_id = '.$doctor_id.',
									comment = '.$comment.'
									WHERE therapy_result_id='.$therapy_result_id;
			$status = 2;
		} else {
			$insert_therapy_sql = 'INSERT INTO '.self::$table.' (therapy_id,doctor_id,comment,relation_id,dosage,frequency,self_prescribed)
									VALUES('.$therapy_id.','.$doctor_id.','.$comment.','.$relation_id.','.$dosage.','.$frequency.','.$self_prescribed.')';
			$status = 1;
		}
		// var_dump($insert_therapy_sql);exit;
		$therapy = $wpdb->query( $insert_therapy_sql );

		if(!isset($efficient)) {
			$efficient = $wpdb->insert_id;
		}
		
		if($therapy === false) {
			$status = 3;
		} elseif($therapy == 0) {
			$status = 0;
		}

		if($therapy !== false) {
			$type = 'therapie';
			$effect_type = "'".$type."'";
			foreach ($effect as $user_symptom_id => $effect_value) {
				$insert_effect_sql = 'INSERT INTO patient_effect
				 					  (type,user_symptom_id,efficient_id,value)
				 					  VALUES('.$effect_type.','.$user_symptom_id.','.$efficient.','.$effect_value.') ON DUPLICATE KEY UPDATE
				 					  value = '.$effect_value.'';
			  	$effect = $wpdb->query( $insert_effect_sql);
			}
		}		

		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _setLifestyle() {
		global $wpdb;

		$lifestyle_id = "'".self::$patient_data['lifestyle_id']."'";		
		$lifestyle_frequency_id = "'".self::$patient_data['lifestyle_frequency_id']."'";
		$relation_id = "'".self::$patient_data['relation_id']."'";
		$comment = "'".self::$patient_data['comment']."'";

		$effect = self::$patient_data['effect'];

		if(null != self::$patient_data['lifestyle_result_id']) {
			$efficient = $lifestyle_result_id = self::$patient_data['lifestyle_result_id'];
			$insert_lifestyle_sql = 'UPDATE '.self::$table.'
									SET lifestyle_frequency_id = '.$lifestyle_frequency_id.',
									comment = '.$comment.'
									WHERE lifestyle_result_id='.$lifestyle_result_id;
			$status = 2;
		} else {
			$insert_lifestyle_sql = 'INSERT INTO '.self::$table.' (lifestyle_id,lifestyle_frequency_id,relation_id,comment)
									VALUES('.$lifestyle_id.','.$lifestyle_frequency_id.','.$relation_id.','.$comment.')';
			$status = 1;
		}
		
		$lifestyle = $wpdb->query( $insert_lifestyle_sql );
		
		if(!isset($efficient)) {
			$efficient = $wpdb->insert_id;
		}
		
		if($lifestyle === false) {
			$status = 3;
		} elseif($lifestyle == 0) {
			$status = 0;
		}

		if($lifestyle !== false) {
			$type = 'lifestyle';
			$effect_type = "'".$type."'";
			foreach ($effect as $user_symptom_id => $effect_value) {
				$insert_effect_sql = 'INSERT INTO patient_effect
				 					  (type,user_symptom_id,efficient_id,value)
				 					  VALUES('.$effect_type.','.$user_symptom_id.','.$efficient.','.$effect_value.') ON DUPLICATE KEY UPDATE
				 					  value = '.$effect_value.'';
			  	$effect = $wpdb->query( $insert_effect_sql);
			}
		}		

		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _addSymptom() {
		global $wpdb;
		$add_symptom = $wpdb->insert(self::$table, self::$patient_data);
		$status = $add_symptom;
		self::$status_code[$status]['id'] = ''.mysql_insert_id().'';
		if($status === false) {
			$status = 3;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _addAssays() {
		global $wpdb;
		$add_assay = $wpdb->insert(self::$table, self::$patient_data);
		$status = $add_assay;
		self::$status_code[$status]['id'] = ''.mysql_insert_id().'';
		if($status === false) {
			$status = 3;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _addDiagnoses() {
		global $wpdb;
		$add_diagnos = $wpdb->insert(self::$table, self::$patient_data);
		$status = $add_diagnos;
		self::$status_code[$status]['id'] = ''.mysql_insert_id().'';
		if($status === false) {
			$status = 3;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _addTherapies() {
		global $wpdb;
		$add_therapy = $wpdb->insert(self::$table, self::$patient_data);
		$status = $add_therapy;
		self::$status_code[$status]['id'] = ''.mysql_insert_id().'';
		if($status === false) {
			$status = 3;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _addLifestyle() {
		global $wpdb;
		$add_lifestyle = $wpdb->insert(self::$table, self::$patient_data);
		$status = $add_lifestyle;
		self::$status_code[$status]['id'] = ''.mysql_insert_id().'';
		if($status === false) {
			$status = 3;
		}
		print_r(json_encode(self::$status_code[$status]));
	}

	public static function _deleteRecovery() {
		global $wpdb;

		$delete_recovery = 'DELETE FROM '.self::$table.' WHERE recovery_id ='.self::$patient_data;
		$status = $wpdb->query($delete_recovery);

		echo $status;
		
	}

	public static function _deleteSymptom() {
		global $wpdb;

		$delete_recovery = 'DELETE FROM '.self::$table.' WHERE user_symptom_id ='.self::$patient_data;
		$status = $wpdb->query($delete_recovery);

		echo $status;

	}

	public static function _deleteAssays() {
		global $wpdb;

		$delete_recovery = 'DELETE FROM '.self::$table.' WHERE assay_result_id ='.self::$patient_data;
		$status = $wpdb->query($delete_recovery);

		echo $status;
	}

	public static function _deleteDiagnoses() {
		global $wpdb;

		$delete_recovery = 'DELETE FROM '.self::$table.' WHERE doctor_diagnosis_id ='.self::$patient_data;
		$status = $wpdb->query($delete_recovery);

		echo $status;
	}

	public static function _deleteTherapies() {
		global $wpdb;

		$delete_recovery = 'DELETE FROM '.self::$table.' WHERE therapy_result_id ='.self::$patient_data;
		$status = $wpdb->query($delete_recovery);

		echo $status;
	}

	public static function _deleteLifestyle() {
		global $wpdb;

		$delete_recovery = 'DELETE FROM '.self::$table.' WHERE lifestyle_result_id ='.self::$patient_data;
		$status = $wpdb->query($delete_recovery);

		echo $status;
	}

	public static function _addDoctor() {

	}

	public static function _addUnit() {

	}

	public static function _addDate() {
		global $wpdb;

		if(self::$patient_data['date'] == '') {
			$status = 3;
			print_r(json_encode(self::$status_code[$status]));
			return;
		}

		$date_array = array(
			'date' => self::$patient_data['date'],
			'user_id' => self::$patient_id, // change to $bp->user_id;
		);
		
		$add_date = $wpdb->insert(self::$table, $date_array);
		$status = $add_date;
		self::$status_code[$status]['id'] = ''.mysql_insert_id().'';
		if($status === false) {
			$status = 3;
		}
		print_r(json_encode(self::$status_code[$status]));

		
	}
	//can't change relation_id but can change single data id
	private function checkUserOnDataUpdate() {
		
		$relations_array = array();
		global $wpdb;
		$relations_sql = 'SELECT * FROM patient_relations WHERE user_id = '.$this->user;
		$relations = $wpdb->get_results($relations_sql);
		foreach ($relations as $relation) {
			array_push($relations_array, $relation->relation_id);
		}
		if(!in_array(self::$patient_data['relation_id'], $relations_array) && self::$action != 'doctor') {
			die();
		}
		$relation_str = implode(',', $relations_array);

		// $check;

	}

	public static function _getallSymptom() {
		global $wpdb;

		$patient_id = self::$patient_id;//change to BuddyPress user_id

		$symptoms_array = array(
			'mental' => array(),
			'sexual' => array(),
			'physical' => array(),
			'hormonal' => array()
		);

		$symptom_sql = 'SELECT * FROM patient_symptoms WHERE symptom_id	NOT IN
						(SELECT S.symptom_id FROM patient_relations R
							INNER JOIN patient_user_symptoms US
							ON R.relation_id = US.relation_id
							INNER JOIN patient_symptoms S
							ON US.symptom_id = S.symptom_id
						WHERE R.user_id = '.$patient_id.')';
		
		$symptoms = $wpdb->get_results($symptom_sql);

		foreach ($symptoms as $symptom) {
			switch ($symptom->symptom_category_id) {				
				case '1':					
						array_push($symptoms_array['mental'], $symptom);									
					break;
				case '2':					
						array_push($symptoms_array['sexual'], $symptom);					
					break;
				case '3':					
						array_push($symptoms_array['physical'], $symptom);					
					break;
				case '4':					
						array_push($symptoms_array['hormonal'], $symptom);					
					break;
			}
		}

		print_r(json_encode($symptoms_array));
	}

	public static function _getallAssays() {
		global $wpdb;

		$patient_id = self::$patient_id;//change to BuddyPress user_id

		$assays_array = array();

		$assay_sql = 'SELECT * FROM patient_assays WHERE assay_id NOT IN
						(SELECT S.assay_id FROM patient_relations R
							INNER JOIN patient_assay_result AR
							ON R.relation_id = AR.relation_id
							INNER JOIN patient_assays S
							ON AR.assay_id = S.assay_id
						WHERE R.user_id = '.$patient_id.')';
		
		$assays = $wpdb->get_results($assay_sql);

		foreach ($assays as $assay) {								
			array_push($assays_array, $assay);			
		}
		
		print_r(json_encode($assays_array));
		
	}
	
	public static function _getallDiagnoses() {
		global $wpdb;

		$patient_id = self::$patient_id;//change to BuddyPress user_id

		$diagnosis_array = array();

		$diagnos_sql = 'SELECT * FROM patient_diagnosis WHERE diagnosis_id NOT IN
						(SELECT D.diagnosis_id FROM patient_relations R
							INNER JOIN patient_doctor_diagnosis DD
							ON R.relation_id = DD.relation_id
							INNER JOIN patient_diagnosis D
							ON DD.diagnosis_id = D.diagnosis_id
						WHERE R.user_id = '.$patient_id.')';
		
		$diagnosis = $wpdb->get_results($diagnos_sql);

		foreach ($diagnosis as $diagnos) {								
			array_push($diagnosis_array, $diagnos);			
		}
		
		print_r(json_encode($diagnosis_array));
	}

	public static function _getallTherapies() {
		global $wpdb;

		$patient_id = self::$patient_id;//change to BuddyPress user_id

		$therapies_array = array();

		$therapy_sql = 'SELECT * FROM patient_therapy WHERE therapy_id NOT IN
						(SELECT T.therapy_id FROM patient_relations R
							INNER JOIN patient_therapy_result TR
							ON R.relation_id = TR.relation_id
							INNER JOIN patient_therapy T
							ON TR.therapy_id = T.therapy_id
						WHERE R.user_id = '.$patient_id.')';
		
		$therapies = $wpdb->get_results($therapy_sql);

		foreach ($therapies as $therapy) {								
			array_push($therapies_array, $therapy);			
		}
		
		print_r(json_encode($therapies_array));
	}

	public static function _getallLifestyle() {
		global $wpdb;

		$patient_id = self::$patient_id;//change to BuddyPress user_id

		$lifestyles_array = array();

		$lifestyle_sql = 'SELECT * FROM patient_lifestyle WHERE lifestyle_id NOT IN
						(SELECT L.lifestyle_id FROM patient_relations R
							INNER JOIN patient_lifestyle_result LR
							ON R.relation_id = LR.relation_id
							INNER JOIN patient_lifestyle L
							ON LR.lifestyle_id = L.lifestyle_id
						WHERE R.user_id = '.$patient_id.')';
		
		$lifestyles = $wpdb->get_results($lifestyle_sql);

		foreach ($lifestyles as $lifestyle) {								
			array_push($lifestyles_array, $lifestyle);			
		}
		
		print_r(json_encode($lifestyles_array));
	}

}

?>
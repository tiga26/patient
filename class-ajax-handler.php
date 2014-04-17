<?php
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ). '/wp-load.php' );
require_once('class-db-manager.php');

$ajax = new Patient_Ajax_Handler();
$ajax->init($_POST);

class Patient_Ajax_Handler{
	
	private $user = 1;
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
		'assays' => array(
			'result' => 'The result field must be above 0',
			'ref_low' => 'Please enter range from 0 - 100%',
			'ref_hi' => 'Please enter range from 0 - 100%',
			),
	);

	private static $type_to_table = array(
		'symptoms' => 'patient_user_symptoms',
		'assays' => 'patient_assay_result',
		'diagnoses' => 'patient_doctor_diagnosis',
		'therapies' => 'patient_therapy_result',
		'lifestyle' => 'patient_lifestyle_result',
		'doctor' => 'patient_doctors',
		'unit' => 'patient_units'
	);

	private static $type_to_id = array(

	);

	public function init($data) {
		
		self::$action = $action_name = $data['action'];
		$action_type = $data['type'];
		self::$patient_data = $data['data'];
		self::$table = self::$type_to_table[$action_name];

		$this->checkUserOnDataUpdate();

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
		// var_dump($doctors_sql);exit;
		$doctors = $wpdb->get_results($doctors_sql);
		var_dump($doctors);exit;
		print_r(json_encode($doctors));
	}

	public static function _setSymptoms() {
		global $wpdb;
		$symptom = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($symptom);
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

		self::$patient_data['ref_percent'] = self::$patient_data['ref_hi'] / self::$patient_data['ref_low'];
		self::$patient_data['remarks'] = "'".self::$patient_data['remarks']."'";
		$assay_data_str = implode(',', self::$patient_data);
		$insert_assay_sql = 'INSERT INTO '.self::$table.'
		 					(assay_id,relation_id,unit_id,result,ref_low,ref_hi,ref_percent,remarks)
		 					VALUES('.$assay_data_str.') ON DUPLICATE KEY UPDATE
		 					unit_id = '.self::$patient_data['unit_id'].',
		 					result = '.self::$patient_data['result'].',
		 					ref_low = '.self::$patient_data['ref_low'].',
		 					ref_hi = '.self::$patient_data['ref_hi'].',
		 					ref_percent = '.self::$patient_data['ref_percent'].',
		 					remarks = '.self::$patient_data['remarks'].'';
		$assay = $wpdb->query( $insert_assay_sql );
		print_r(json_encode(self::$status_code[$assay]));
	}

	public static function _setDiagnoses() {
		global $wpdb;
		$diagnos = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($diagnos);
	}

	public static function _setTherapies() {
		global $wpdb;
		$therapy = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($therapy);
	}

	public static function _setLifestyle() {
		global $wpdb;
		$lifestyle = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($lifestyle);
	}

	public static function _addSymptom() {
		global $wpdb;
	}

	public static function _addAssay() {

	}

	public static function _addDiagnos() {

	}

	public static function _addTherapy() {

	}

	public static function _addLifestyle() {

	}

	public static function _addDoctor() {

	}

	public static function _addUnit() {

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

}

?>
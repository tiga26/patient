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
			'message' => 'Custom message',
		)
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
		
		$action_name = $data['action'];
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

	public static function _setSymptoms() {
		global $wpdb;
		$symptom = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($symptom);
	}

	public static function _setAssays() {
		global $wpdb;
		// check inserting data use is_numeric function
		// if() {

		// }
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
		if(!in_array(self::$patient_data['relation_id'], $relations_array)) {
			die();
		}
		$relation_str = implode(',', $relations_array);

		// $check;

	}

}

?>
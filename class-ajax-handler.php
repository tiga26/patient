<?php
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ). '/wp-load.php' );
require_once('class-db-manager.php');

$ajax = new Patient_Ajax_Handler();
$ajax->init($_POST);

class Patient_Ajax_Handler{
	
	private static $table;
	private static $patient_data;
	private static $action_type;	
	// private static $patient;
	private static $status_code = array(
		'' => array(
			'code' => '1',
			'message' => 'Ok',
		),
		'' => array(
			'code' => '0',
			'message' => 'Forbidden',
		),
	);

	private static $type_to_table = array(
		'symptom' => 'patient_user_symptoms',
		'assay' => 'patient_assay_result',
		'diagnos' => 'patient_doctor_diagnosis',
		'therapy' => 'patient_therapy_result',
		'lifestyle' => 'patient_lifestyle_result',
	);

	public function init($data) {

		$action_name = $data['action'];
		$action_type = $data['type'];
		self::$patient_data = $data['data'];
		self::$table = self::$type_to_table[$action_name];

		add_action('wp_ajax_'.$action_name, array( 'Patient_Ajax_Handler', '_'.$action_type.ucfirst($action_name) ) );
		do_action('wp_ajax_'.$action_name);
	}

	public static function _getSymptom() {
		global $wpdb;
		$symptom_sql = 'SELECT * FROM '.self::$table.' WHERE user_symptom_id = '.self::$patient_data['id'];
		$symptom = $wpdb->get_results($symptom_sql);
		var_dump($symptom);
	}

	public static function _getAssay() {
		global $wpdb;
		$assay_sql = 'SELECT * FROM '.self::$table.' WHERE assay_result_id = '.self::$patient_data['id'];
		$assay = $wpdb->get_results($assay_sql);
		var_dump($assay);
	}

	public static function _getDiagnos() {
		global $wpdb;
		$diagnos_sql = 'SELECT * FROM '.self::$table.' WHERE diagnosis_id = '.self::$patient_data['id'];
		$diagnos = $wpdb->get_results($diagnos_sql);		
	}

	public static function _getTherapy() {
		global $wpdb;
		$therapy_sql = 'SELECT * FROM '.self::$table.' WHERE therapy_result_id = '.self::$patient_data['id'];
		$therapy = $wpdb->get_results($therapy_sql);	
	}

	public static function _getLifestyle() {
		global $wpdb;
		$lifestyle_sql = 'SELECT * FROM '.self::$table.' WHERE lifestyle_result_id = '.self::$patient_data['id'];
		$lifestyle = $wpdb->get_results($lifestyle_sql);	
	}

	public static function _setSymptom() {
		global $wpdb;
		$symptom = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($symptom);
	}

	public static function _setAssay() {
		global $wpdb;
		self::$patient_data['ref_percent'] = self::$patient_data['ref_hi'] / self::$patient_data['ref_low'];
		$assay = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($assay);		
	}

	public static function _setDiagnos() {
		global $wpdb;
		$diagnos = $wpdb->insert(self::$table, self::$patient_data);
		var_dump($diagnos);
	}

	public static function _setTherapy() {
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

}

?>
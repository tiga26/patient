<?php
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ). '/wp-load.php' );
require_once('class-db-manager.php');

// function text_ajax_process_request() {
// 	// first check if data is being sent and that it is the data we want
//   	if ( isset( $_POST["post_var"] ) ) {
// 		// now set our response var equal to that of the POST var (this will need to be sanitized based on what you're doing with with it)
// 		$response = $_POST["post_var"];
// 		// send the response back to the front end
// 		echo $response;
// 		die();
// 	}
// }
// add_action('wp_ajax_test_response', 'text_ajax_process_request');

// do_action( 'wp_ajax_test_response' );
$ajax = new Patient_Ajax_Handler();
$ajax->init($_POST);

class Patient_Ajax_Handler{
	
	private $table;
	private static $patient_data;

	public function init($data) {

		$action = $data['action'];
		self::$patient_data = $data['data'];
		add_action('wp_ajax_'.$action, array( 'Patient_Ajax_Handler', 'get'.ucfirst($action) ) );
		do_action('wp_ajax_'.$action);
	}

	public function getPatientData($data_type) {

	}

	public function setPatientData() {

	}

	public static function getSymptom() {
		var_dump(self::$patient_data);
	}

	private function getAssay() {
		
	}

	private function getDiagnos() {
		
	}

	private function getTherapie() {

	}

	private function getLifestyle() {

	}

	private function setSymptom() {

	}

	private function setAssay() {
		
	}

	private function setDiagnos() {
		
	}

	private function setTherapie() {
		
	}

	private function setLifestyle() {
		
	}
}
?>
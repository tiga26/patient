<?php
/*
 *Plugin Name: Patient
 */

require_once dirname(__FILE__).'/class-patient.php';
require_once dirname(__FILE__).'/class-db-manager.php';

$db_structure = require_once dirname(__FILE__).'/db-structure.php';
$patient_plugin = new Patient_PLugin();
$patient_plugin->setDbStructure($db_structure);
Patient_Plugin::init(__FILE__);

add_action("admin_menu", "createPatientPage");
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

function load_custom_wp_admin_style() {
    wp_enqueue_script( 'custom_wp_admin_css' );
}

function createPatientPage() {
	$js_url = plugins_url().'/patient/js';

    add_menu_page("Patient", "Patient", 0, "patient-menu", "PatientMainPage");
    add_submenu_page("patient-menu", "Settings", "Settings", 0, "settings-slug", "settingsPage");
    add_submenu_page("patient-menu", "Symptoms", "Symptoms", 0, "symptoms-slug", "symptomsPage");
    add_submenu_page("patient-menu", "Assays", "Assays", 0, "assays-slug", "assaysPage");
    add_submenu_page("patient-menu", "Diagnosis", "Diagnosis", 0, "diagnosis-slug", "diagnosisPage");
    add_submenu_page("patient-menu", "Therapies", "Therapies", 0, "therapies-slug", "therapiesPage");
    add_submenu_page("patient-menu", "Lifestyle", "Lifestyle", 0, "lifestyle-slug", "lifestylePage");
    add_submenu_page("patient-menu", "Units", "Units", 0, "units-slug", "unitsPage");
    add_submenu_page("patient-menu", "Doctors", "Doctors", 0, "doctors-slug", "doctorsPage");
    add_action('admin_print_scripts', 'ajax_load_scripts');
    wp_enqueue_script( 'jquery-admin', $js_url.'/admin.js', array('jquery'));	
    
}

function PatientMainPage() {
	echo 'Main Page';
	
}

function settingsPage() {
	echo 'Settings Page';
}

function symptomsPage() {
	echo 'Symptoms Page';
	getTable('symptoms');	
}

function assaysPage() {
	echo 'Assays Page';
	getTable('assays');	
}

function diagnosisPage() {
	echo 'Diagnosis Page';
	getTable('diagnosis');
}

function therapiesPage() {
	echo 'Therapies Page';
	getTable('therapies');
}

function lifestylePage() {
	echo 'Lifestyle Page';
	getTable('lifestyle');
}

function unitsPage() {
	echo 'Units Page';
	getTable('units');
}

function doctorsPage() {
	echo 'Doctors Page';
	getTable('doctors');
}

function renderTable($items) {
	if(empty($items)) {
		return 'No Data';
	}

	$table = '<table>';
	$table .= '<thead>';
	$table .= '<tr>';
	$table .= '<th>ID</th>';
	$table .= '<th>Name</th>';
	$table .= '<th>Comment</th>';	
	$table .= '<th>Edit</th>';	
	$table .= '<th>Delete</th>';	
	$table .= '</tr>';
	$table .= '</thead>';
	$table .= '<tbody>';
	
	foreach ($items as $key => $value) {
		$table .= '<tr>';
		$table .= '<td>'. $value->id .'</td>';
		$table .= '<td>'. $value->name .'</td>';
		$table .= '<td>'. $value->comment .'</td>';		
		$table .= '<td id="edit" data-id="'.$value->id.'">Edit</td>';		
		$table .= '<td data-id="'.$value->id.'">Delete</td>';		
		$table .= '</tr>';
	}

	$table .= '</tbody>';
	$table .= '</table>';
	
	return $table;
}

function getTable($page = '') {
	if(empty($page)) {
		return 'Wrong Page Name';
	}
	$items = getAdminData($page);	

	$table = renderTable($items);
	echo $table;
}

function getAdminSymptoms() {
	global $wpdb;

	$symptoms_sql = 'SELECT symptom_id as id,name,comment FROM patient_symptoms WHERE approved = 0';
	$symptoms = $wpdb->get_results($symptoms_sql);
	
	return $symptoms;
}

function getAdminAssays() {
	global $wpdb;

	$assays_sql = 'SELECT assay_id as id,name,comment FROM patient_assays WHERE approved = 0';
	$assays = $wpdb->get_results($assays_sql);
	
	return $assays;
}

function getAdminDiagnosis() {
	global $wpdb;

	$diagnosis_sql = 'SELECT diagnosis_id as id,name,comment FROM patient_diagnosis WHERE approved = 0';
	$diagnosis = $wpdb->get_results($diagnosis_sql);
	
	return $diagnosis;
}

function getAdminTherapies() {
	global $wpdb;

	$therapies_sql = 'SELECT therapy_id as id,name,comment FROM patient_therapy WHERE approved = 0';
	$therapies = $wpdb->get_results($therapies_sql);
	
	return $therapies;
}

function getAdminLifestyle() {
	global $wpdb;

	$lifestyle_sql = 'SELECT lifestyle_id as id,name,comment FROM patient_lifestyle WHERE approved = 0';
	$lifestyle = $wpdb->get_results($lifestyle_sql);
	
	return $lifestyle;
}

function getAdminUnits() {
	global $wpdb;

	$unit_sql = 'SELECT unit_id as id,name,comment FROM patient_units WHERE approved = 0';
	$units = $wpdb->get_results($unit_sql);
	
	return $units;
}

function getAdminDoctors() {
	global $wpdb;

	$doctor_sql = 'SELECT doctor_id as id,name,comment FROM patient_units WHERE approved = 0';
	$doctors = $wpdb->get_results($doctor_sql);
	
	return $doctors;
}

function getAdminData($page) {
	$items = array();
	$method_name = 'getAdmin'.ucfirst($page);
	if(function_exists($method_name)) {
		$items = $method_name();
	}
	return $items;
}

function ajax_load_scripts() {	
	
	wp_localize_script( 'ajax-test', 'admin_ajax_script', array( 'ajaxurl' => plugin_dir_url( __FILE__ ).'admin-ajax-handler.php' ) );	
}
?>
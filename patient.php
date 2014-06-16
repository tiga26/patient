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
    wp_enqueue_script( 'jquery-confirm', $js_url.'/jquery.confirm.min.js', array('jquery'));
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

function renderTable($items = array()) {
	if(!empty($items)) {
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
		$table .= '<td>'. $value['id'] .'</td>';
		$table .= '<td>'. $value['name'] .'</td>';
		$table .= '<td>'. $value['comment'] .'</td>';		
		$table .= '<td data-id="'.$value['id'].'">Edit</td>';		
		$table .= '<td data-id="'.$value['id'].'">Delete</td>';		
		$table .= '</tr>';
	}

	$table .= '</tbody>';
	$table = '</table>';

	return $table;
}

function getTable($page = '') {
	if(empty($page)) {
		return 'Wrong Page Name';
	}
	$items = '';
	switch ($page) {
		case 'symptoms':
			$items = getAdminSymptoms();
			break;
		case 'assays':
			$items = getAdminAssays();
			break;
		case 'diagnosis':
			$items = getAdminDiagnosis();
			break;
		case 'therapies':
			$items = getAdminTherapies();
			break;
		case 'lifestyle':
			$items = getAdminLifestyle();
			break;
		case 'units':
			$items = getAdminUnits();
			break;
		case 'doctors':
			$items = getAdminDoctors();
			break;
	}

	$table = renderTable($items);
	echo $table;
}



?>
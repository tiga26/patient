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


// if(!function_exists('wp_get_current_user')) {
//     include(ABSPATH . "wp-includes/pluggable.php"); 
// }

// var_dump(get_current_user_id());
// if (function_exists("bp_loggedin_user_id")){
//     var_dump(bp_loggedin_user_id());
// }


// $patient_plugin->setDbStructure($db_structure);
// 			   ->createTables();
// $patient_manager = new Patient_Db_Manager();
// $patient_data = $patient_manager->setPatient(1)
// 								->loadPatientData('symptoms')
// 								->getPatientData();

?>
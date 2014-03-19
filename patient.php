<?php

/*
 * Plugin Name: Patient
 */

require_once dirname(__FILE__).'/class-patient.php';
require_once dirname(__FILE__).'/class-db-manager.php';

$db_structure = require_once dirname(__FILE__).'/db-structure.php';
$patient_plugin = new Patient_Plugin();
$patient_plugin->setDbStructure($db_structure);
Patient_Plugin::init(__FILE__);

?>
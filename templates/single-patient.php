<?php
/*
Template Name: Patient Statistics
*/
require_once dirname(__FILE__).'/../class-db-manager.php';

$patient = new Patient_Db_Manager();

$patient_data = $patient->setPatient(1)
						->loadPatientAllData()
						->getPatientData();
var_dump($patient_data);
?>
<?php
function approveSymptoms($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];

	global $wpdb;
	$symptoms_sql = 'UPDATE patient_symptoms SET approved = 1 WHERE symptom_id = '.$id;
}

function approveAssays($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];

	global $wpdb;
	$assays_sql = 'UPDATE patient_assays SET approved = 1 WHERE assay_id = '.$id;
}

function approveDiagnosis($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];

	global $wpdb;
	$assays_sql = 'UPDATE patient_diagnosis SET approved = 1 WHERE diagnosis_id = '.$id;
}

function approveTherapies($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];

	global $wpdb;
	$assays_sql = 'UPDATE patient_therapy SET approved = 1 WHERE therapy_id = '.$id;
}

function approveLifestyle($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];

	global $wpdb;
	$assays_sql = 'UPDATE patient_lifestyle SET approved = 1 WHERE lifestyle_id = '.$id;
}

function approveUnits($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];

	global $wpdb;
	$assays_sql = 'UPDATE patient_units SET approved = 1 WHERE unit_id = '.$id;
}

function approveDoctors($data = array()) {
	$id = $data['id'];
	$name = $data['name'];
	$comment = $data['comment'];
	
	global $wpdb;
	$assays_sql = 'UPDATE patient_doctors SET approved = 1 WHERE doctor_id = '.$id;
}

?>
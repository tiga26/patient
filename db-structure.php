<?php
/*
 *The file that returns the db structure with it tables
 *structures which must be created on Patinet plugin activation
 */
return array(
	'tables' => array(

		'relations' => array(
			'fields' => array(
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
					
				),
				'date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'user_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
			),

			'primary_key' => 'relation_id',
			'engine' => 'InnoDB',
		),

		'recovery_status' => array(
			'fields' => array(
				'recovery_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),				
				'remarks' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'value' => array(
					'type' => ' INT',
					'length' => '(3)',
					'nonull' => '',
					'autoincrement' => '',
				),
			),

			'primary_key' => 'recovery_id',
			'engine' => 'InnoDB',
		),

		'user_symptoms' => array(
			'fields' => array(
				'user_symptom_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'value' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'symptom_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),								
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),

			),

			'primary_key' => 'user_symptom_id',
			'engine' => 'InnoDB',
		),

		'symptoms' => array(
			'fields' => array(
				'symptom_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'symptom_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'submit_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'symptom_id',
			'engine' => 'InnoDB',		
		),

		'symptoms_category' => array(
			'fields' => array(
				'symptom_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'symptom_category_id',
			'engine' => 'MYISAM',
		),

		'assays' => array(
			'fields' => array(
				'assay_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'assay_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'submit_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'assay_id',
			'engine' => 'InnoDB',
		),
		//delete last comma if there is no primary key
		'assay_result' => array(
			'fields' => array(
				'assay_result_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'assay_id' => array(
					'type' => ' INT',
					'length' => '(1)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(1)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'unit_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'result' => array(
					'type' => ' FLOAT',
					'length' => '(3,3)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'ref_low' => array(
					'type' => ' FLOAT',
					'length' => '(3,3)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'ref_hi' => array(
					'type' => ' FLOAT',
					'length' => '(3,3)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'ref_percent' => array(
					'type' => ' INT',
					'length' => '(3)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'remarks' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'assay_result_id',
			'engine' => 'InnoDB',
		),
		'assay_links' => array(
			'fields' => array(
				'assay_link_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'assay_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'assay_id_requires' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'assay_link_id',
			'engine' => 'InnoDB',
		),
		'assay_category' => array(
			'fields' => array(
				'assay_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'assay_category_id',
			'engine' => 'InnoDB',
		),
		'units' => array(
			'fields' => array(
				'unit_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'unit' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),				
				'submit_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),				
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),				
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'unit_id',
			'engine' => 'InnoDB',
		),

		'therapy_result' => array(
			'fields' => array(
				'therapy_result_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'therapy_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'start_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'end_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'doctor_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'rating' => array(
					'type' => ' INT',
					'length' => '(3)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),				
				'dosage' => array(
					'type' => ' INT',
					'length' => '(5)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'frequency' => array(
					'type' => ' INT',
					'length' => '(5)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'frequency' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'therapy_result_id',
			'engine' => 'InnoDB',
		),
		'therapy' => array(
			'fields' => array(
				'therapy_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'therapy_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'therapy_id',
			'engine' => 'InnoDB',
		),
		'therapy_category' => array(
			'fields' => array(
				'therapy_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'therapy_category_id',
			'engine' => 'InnoDB',
		),

		'lifestyle_result' => array(
			'fields' => array(
				'lifestyle_result_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'lifestyle_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'lifestyle_frequency_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'doctor_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'start_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'end_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'lifestyle_result_id',
			'engine' => 'InnoDB',
		),
		'lifestyle' => array(
			'fields' => array(
				'lifestyle_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'lifestyle_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'submit_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'lifestyle_id',
			'engine' => 'InnoDB',
		),
		'lifestyle_frequency' => array(
			'fields' => array(
				'lifestyle_frequency_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' ENUM',
					'length' => '("Once a day or more","Once a week or more","Once a month or more")',
					'nonull' => '',
					'autoincrement' => '',
				),
				'quantity' => array(
					'type' => ' INT',
					'length' => '(2)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'frequency' => array(
					'type' => ' ENUM',
					'length' => '("Day","Week","Month")',
					'nonull' => '',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'lifestyle_frequency_id',
			'engine' => 'InnoDB',
		),
		'lifestyle_category' => array(
			'fields' => array(
				'lifestyle_category_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'lifestyle_category_id',
			'engine' => 'InnoDB',
		),

		'effect' => array(
			'fields' => array(
				'effect_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'type' => array(
					'type' => ' ENUM',
					'length' => '("therapie","lifestyle")',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'user_symptom_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'efficient_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'value' => array(
					'type' => ' TINYINT',
					'length' => '(3)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'effect_id',
			'engine' => 'InnoDB',
		),
		//must think if we need this table or not
		'doctor_to_user' => array(
			'fields' => array(
				'rel_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'user_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'doctor_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
			),
			'primary_key' => 'rel_id',
			'engine' => 'InnoDB',
		),
		'doctors' => array(
			'fields' => array(
				'doctor_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'city' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'country' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => '',
					'autoincrement' => '',
				),
				'submit_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),

			),
			'primary_key' => 'doctor_id',
			'engine' => 'InnoDB',
		),
		'diagnosis' => array(
			'fields' => array(
				'diagnosis_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'name' => array(
					'type' => ' VARCHAR',
					'length' => '(255)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),
				'submit_date' => array(
					'type' => ' DATE',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),
				'approved' => array(
					'type' => ' TINYINT',
					'length' => '(1)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),

			),
			'primary_key' => 'diagnosis_id',
			'engine' => 'InnoDB',
		),
		'doctor_diagnosis' => array(
			'fields' => array(
				'doctor_diagnosis_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => ' AUTO_INCREMENT',
				),
				'diagnosis_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),				
				'doctor_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),				
				'comment' => array(
					'type' => ' TEXT',
					'length' => '',
					'nonull' => '',
					'autoincrement' => '',
				),				
				'relation_id' => array(
					'type' => ' INT',
					'length' => '(11)',
					'nonull' => ' NOT NULL',
					'autoincrement' => '',
				),

			),
			'primary_key' => 'doctor_diagnosis_id',
			'engine' => 'InnoDB',
		),		

	),

	'prefix' => 'patient_',
)

?>
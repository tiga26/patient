<?php
/*
 * Template Name: Patient Statistics
 */
require_once dirname(__FILE__).'/../class-db-manager.php';

if(validDate($_GET['start_date']) && validDate($_GET['end_date'])) {
	$dates['start'] = $_GET['start_date'];
	$dates['end'] = $_GET['end_date'];
} else {
	$dates = array();
}

$patient = new Patient_Db_Manager();
// echo '<pre>';
$patient_data = $patient->setPatient(1)
						->loadPatientAllData($dates)
						->getPatientData();

// var_dump('dates',$patient_data->dates);
// echo '<br>';
// echo '<br>';
// var_dump('recovery',$patient_data->recovery);
// echo '<br>';
// echo '<br>';
// var_dump('symptoms',$patient_data->symptoms);
// echo '<br>';
// echo '<br>';
// var_dump('assays',$patient_data->assays);
// echo '<br>';
// echo '<br>';
// var_dump('diagnosis',$patient_data->diagnosis);
// echo '<br>';
// echo '<br>';
// var_dump('therapies',$patient_data->therapies);
// echo '<br>';
// echo '<br>';
// var_dump('lifestyle',$patient_data->effects['therapy']);
// exit;
get_header();
?>
<div class="main-container">
	<div>
	 	<div class="top_table_block">
		 	<table class="recovery">
		 		<tr class="dates">
		 			<td id='dates'>Dates</td>
		 			<?php foreach ($patient_data->dates as $date) : ?>
		 				<td data-relation-id="<?php echo $date->relation_id;?>"><input type="checkbox"><?php echo $date->date;?></td>
		 			<?php endforeach;?>
		 		</tr>
		 		<tr class="rec_status">
		 			<td>Recovery Status</td>
		 			<?php foreach ($patient_data->recovery as $recovery) : ?>
		 				<?php if(empty($recovery)): ?>
		 					<td><div class="comment"><div>---</div></div></td>
		 				<?php else: ?>
		 					<td data-recovery-id="<?php echo $recovery->recovery_id;?>">
				 				<div class="comment"><div><?php echo $recovery->value;?>%</div><div class="comment_icon" title="<div class='comment_block'><div>User Coment</div><br><?php echo $recovery->remarks;?></div>"></div></div></div>
				 			</td>
				 		<?php endif; ?>
		 			<?php endforeach;?>
		 		</tr>
		 	</table>
		</div>
	 	<div id="accordion">
	 		<div class="header-line">
	 			<div class="first-child">Symptoms</div><div class="btn my active" data-table='symptom'>my symptoms</div><div class="btn all" data-table='symptom'>all symptoms</div>
	 		</div>
	 		<div>
	 			<div id="accordion1">
	 				<div data-category-id="1">Mental Symptoms</div>
	 				<table class="symptom">
	 					<?php foreach ($patient_data->symptoms['mental'] as $symptom_id => $symptom_array) : ?>
	 						<?php $tmp_symptom = current(array_filter($symptom_array));?>
	 						<?php $symptom_name = $tmp_symptom->symptom_name;?>
	 						<tr data-symptom-id="<?php echo $symptom_id;?>">
		 						<td><input type="checkbox"><label><?php echo $symptom_name;?></label></td>
		 						<?php foreach ($symptom_array as $symptom_id => $symptom):?>
					 				<?php if(empty($symptom)): ?>
					 					<td class="none">None</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>">
							 				<div class="comment">
							 					<div><?php echo $symptom->value;?></div>
							 					<div class="comment_icon" title="<div class='comment_block'><div>User Coment</div><br><?php echo $symptom->comment;?></div>"></div>
							 				</div>
							 			</td>
							 		<?php endif; ?>
						 		<?php endforeach;?>
						 	</tr>
			 			<?php endforeach;?>
	 				</table>
	 				<div data-category-id="2">Sexual Symptoms</div>
	 				<table class="symptom">
	 					<?php foreach ($patient_data->symptoms['sexual'] as $symptom_id => $symptom_array) : ?>
	 						<?php $tmp_symptom = current(array_filter($symptom_array));?>
	 						<?php $symptom_name = $tmp_symptom->symptom_name;?>
	 						<tr data-symptom-id="<?php echo $symptom_id;?>">
		 						<td><input type="checkbox"><label><?php echo $symptom_name;?></label></td>
		 						<?php foreach ($symptom_array as $symptom_id => $symptom):?>
					 				<?php if(empty($symptom)): ?>
					 					<td class="none">None</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>">
							 				<div class="comment">
							 					<div><?php echo $symptom->value;?></div>
							 					<div class="comment_icon" title="<div class='comment_block'><div>User Coment</div><br><?php echo $symptom->comment;?></div>"></div>
							 				</div>
							 			</td>
							 		<?php endif; ?>
						 		<?php endforeach;?>
						 	</tr>	
			 			<?php endforeach;?>
	 				</table>
	 				<div data-category-id="3">Physical Symptoms</div>
	 				<table class="symptom">
	 					<?php foreach ($patient_data->symptoms['physical'] as $symptom_id => $symptom_array) : ?>
	 						<?php $tmp_symptom = current(array_filter($symptom_array));?>
	 						<?php $symptom_name = $tmp_symptom->symptom_name;?>
	 						<tr data-symptom-id="<?php echo $symptom_id;?>">
		 						<td><input type="checkbox"><label><?php echo $symptom_name;?></label></td>
		 						<?php foreach ($symptom_array as $symptom_id => $symptom):?>
					 				<?php if(empty($symptom)): ?>
					 					<td class="none">None</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>">
							 				<div class="comment">
							 					<div><?php echo $symptom->value;?></div>
							 					<div class="comment_icon" title="<div class='comment_block'><div>User Coment</div><br><?php echo $symptom->comment;?></div>"></div>
							 				</div>
							 			</td>
							 		<?php endif; ?>
						 		<?php endforeach;?>
						 	</tr>	
			 			<?php endforeach;?>
	 				</table>
	 				<div data-category-id="4">Hormonal Symptoms</div>
	 				<table class="symptom">
	 					<?php foreach ($patient_data->symptoms['hormonal'] as $symptom_id => $symptom_array) : ?>
	 						<?php $tmp_symptom = current(array_filter($symptom_array));?>
	 						<?php $symptom_name = $tmp_symptom->symptom_name;?>
	 						<tr data-symptom-id="<?php echo $symptom_id;?>">
		 						<td><input type="checkbox"><label><?php echo $symptom_name;?></label></td>
		 						<?php foreach ($symptom_array as $symptom_id => $symptom):?>
					 				<?php if(empty($symptom)): ?>
					 					<td class="none">None</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>">
							 				<div class="comment">
							 					<div><?php echo $symptom->value;?></div>
							 					<div class="comment_icon" title="<div class='comment_block'><div>User Coment</div><br><?php echo $symptom->comment;?></div>"></div>
							 				</div>
							 			</td>
							 		<?php endif; ?>
						 		<?php endforeach;?>
						 	</tr>	
			 			<?php endforeach;?>
	 				</table>
	 			</div>
			</div>
	 		<div class="header-line">
	 			<div class="first-child">Assays</div><div class="btn my active" data-table='assays'>my assays</div><div class="btn all" data-table='assays'>all assays</div>
	 		</div>
			<div>
				<table class="assays">
					<?php foreach ($patient_data->assays as $assay_id => $assay_array) : ?>
 						<?php $tmp_assay = current(array_filter($assay_array));?>
 						<?php $assay_name = $tmp_assay->assay_name;?>
 						<tr data-assay-id="<?php echo $assay_id;?>">
	 						<td><input type="checkbox"><label><?php echo $assay_name;?></label></td>
	 						<?php foreach ($assay_array as $assay_id => $assay):?>
				 				<?php if(empty($assay)): ?>
				 					<td class="none">None</td>
				 				<?php else: ?>
						 			<td data-assay-result-id="<?php echo $assay->assay_result_id;?>">
						 				<div class="comment">
						 					<div><?php echo $assay->result;?></div>
						 					<div class="comment_icon" title="<div class='comment_block'>
						 														<div>Result<span>*</span>:</div><div class='value'><?php echo $assya->result;?>mg</div>
						 														<div>Reference<span>*</span>:</div><div class='value'><?php echo $assay->ref_low;?>mg - <?php echo $assay->ref_hi;?>mg = <?php echo $assay->ref_percent;?>%</div>
						 														<div>User Coment</div><br><br><br><?php echo $assay->remarks;?>
					 														 </div>">
											</div>
						 				</div>
						 			</td>
						 		<?php endif; ?>
					 		<?php endforeach;?>
					 	</tr>
		 			<?php endforeach;?>					
				</table>
			</div>
			<div class="header-line">
				<div class="first-child">Diagnoses</div><div class="btn my active" data-table='diagnoses'>my diagnoses</div><div class="btn all" data-table='diagnoses'>all diagnoses</div>
			</div>
			<div>
				<table class="diagnoses">
					<?php foreach ($patient_data->diagnosis as $diagnosis_id => $diagnosis_array) : ?>
 						<?php $tmp_diagnos = current(array_filter($diagnosis_array));?>
 						<?php $diagnos_name = $tmp_diagnos->name;?>
 						<tr data-diagnosis-id="<?php echo $diagnosis_id;?>">
	 						<td><input type="checkbox"><label><?php echo $diagnos_name;?></label></td>
	 						<?php foreach ($diagnosis_array as $diagnosis_id => $diagnos):?>
				 				<?php if(empty($diagnos)): ?>
				 					<td class="none">None</td>
				 				<?php else: ?>
						 			<td data-doctor-diagnosis-id="<?php echo $diagnos->doctor_diagnosis_id;?>">
						 				<div class="comment">
						 					<div><?php echo $diagnos->doc_name;?></div>
						 					<div class="comment_icon" title="<div class='comment_block'>
					 														 	<div>Doctor</div>
					 														 	<div class='value'><?php echo $diagnos->doc_name;?>,<?php echo $diagnos->country;?></div>
					 														 	<div>Comment</div><br><br><?php echo $diagnos->comment;?>
					 														 </div>">
											</div>
						 				</div>
						 			</td>
						 		<?php endif; ?>
					 		<?php endforeach;?>
					 	</tr>
		 			<?php endforeach;?>
				</table>
			</div>
			<div class="header-line">
				<div class="first-child">Therapies</div><div class="btn my active" data-table='therapies'>my therapies</div><div class="btn all" data-table='therapies'>all therapies</div>
			</div>
			<div>
				<table class="therapies">
					<?php foreach ($patient_data->therapies as $therapy_id => $therapies_array) : ?>
 						<?php $tmp_therapy = current(array_filter($therapies_array));?>
 						<?php $therapy_name = $tmp_therapy->name;?>
 						<tr data-therapy-id="<?php echo $therapy_id;?>">
	 						<td><input type="checkbox"><label><?php echo $therapy_name;?></label></td>
	 						<?php foreach ($therapies_array as $therapy_id => $therapy):?>
				 				<?php if(empty($therapy)): ?>
				 					<td class="none">None</td>
				 				<?php else: ?>
						 			<td>
						 				<div class="comment">
						 					<div><?php echo $therapy->dosage;?>ml/<?php echo $therapy->frequency;?></div>
						 					<div class="comment_icon" title="<div class='comment_block'>
						 													 	<div>Dosage:</div><div class='value'>15ml every 1 day</div>
						 													 	<div>Doctor:</div><div class='value'>Dr. Mindesaa,USA</div>						 													 	
						 													 	<?php if(!empty($patient_data->effects['therapy'])):?>
						 													 		<div>Effect:</div><br>
						 													 		<div class='block_header'>
						 													 			<div id='left_column_header'>Symptom</div>
						 													 			<div id='right_column_header'>Effect</div>
						 													 			<br>
						 													 		</div>
						 													 	<?php endif; ?>						 													 	
						 													 	<?php if(array_key_exists($therapy->therapy_result_id,$patient_data->effects['therapy'])):?>
							 													 	<div>
							 													 		<div class='effect_main_block'>
							 													 			<div class='row'><?php echo $patient_data->effects['therapy'][$therapy->therapy_result_id]->name;?><div class='value'><?php echo $patient_data->effects['therapy'][$therapy->therapy_result_id]->value;?></div></div>
							 													 		</div>
							 			 										 	</div>
					 			 										 		<?php endif;?>
						 													 	<div class='bottom-block'>User Coment</div><?php echo $therapy->comment;?>.
						 													 </div>">
											</div>
						 				</div>
						 			</td>
						 		<?php endif; ?>
					 		<?php endforeach;?>
					 	</tr>
		 			<?php endforeach;?>
				</table>
			</div>
			<div class="header-line">
				<div class="first-child">Lyfestyle</div><div class="btn my active" data-table='lifestyle'>my lifestyle type</div><div class="btn all" data-table='lifestyle'>all lifestyle types</div>
			</div>
			<div>
				<table class="lifestyle">
					<?php foreach ($patient_data->lifestyle as $lifestyle_id => $lifestyles_array) : ?>
 						<?php $tmp_lifestyle = current(array_filter($lifestyles_array));?>
 						<?php $lifestyle_name = $tmp_lifestyle->name;?>
 						<tr data-lifestyle-id="<?php echo $lifestyley_id;?>">
	 						<td><input type="checkbox"><label><?php echo $lifestyle_name;?></label></td>
	 						<?php foreach ($lifestyles_array as $lifestyle_id => $lifestyle):?>
				 				<?php if(empty($lifestyle)): ?>
				 					<td class="none">None</td>
				 				<?php else: ?>
						 			<td>
						 				<div class="comment">
						 					<div><?php echo $lifestyle->quantity;?>/<?php echo $lifestyle->frequency;?></div>
						 					<div class="comment_icon" title="<div class='comment_block'>
						 														<?php echo $lifestyle->quantity;?>/<?php echo $lifestyle->frequency;?>
						 														<br>
						 														<?php if(!empty($patient_data->effects['therapy'])):?>
						 													 		<div>Effect:</div><br>
						 													 		<div class='block_header'>
						 													 			<div id='left_column_header'>Symptom</div>
						 													 			<div id='right_column_header'>Effect</div>
						 													 			<br>
						 													 		</div>
						 													 	<?php endif; ?>						 													 	
						 													 	<?php if(array_key_exists($lifestyle->lifestyle_result_id,$patient_data->effects['lifestyle'])):?>
							 													 	<div>
							 													 		<div class='effect_main_block'>
							 													 			<div class='row'><?php echo $patient_data->effects['lifestyle'][$lifestyle->lifestyle_result_id]->name;?><div class='value'><?php echo $patient_data->effects['lifestyle'][$lifestyle->lifestyle_result_id]->value;?></div></div>
							 													 		</div>
							 			 										 	</div>
					 			 										 		<?php endif;?>
																				<div class='bottom-block'>User Coment</div><?php echo $lifestyle->comment;?>.
																			</div>">										 					
											</div>
						 				</div>
						 			</td>
						 		<?php endif; ?>
					 		<?php endforeach;?>
					 	</tr>
		 			<?php endforeach;?>
					<!-- <tr>
						<td><input type="checkbox">Daily Physical Training<br></td>
						<td>1/Day</td>
						<td><div class="comment">
								<div>1/Day</div>
									<div class="comment_icon" title="
																	<div class='comment_block'>
																		<div class='frequency_main_block'>
																			<div class='row'>
																				<div class='left_part'>1/Day</div>
																				Once a day or more
																			</div>
																			<div class='row'>
																				<div class='left_part'>1/Month</div>
																				Once a month or more
																			</div>
																		</div>
																		<div>Effect:</div><br>
																		<div class='block_header'>
																			<div id='left_column_header'>Symptom</div>
																			<div id='right_column_header'>Effect</div>
																			<br>
																		</div>
																		<div>
																			<div class='effect_main_block'>
																				<div class='row'>Symptom1<div class='value'>1</div></div>
																				<div class='row'>Symptom1<div class='value'>1</div></div>
																			</div>
																		</div>
																		<div class='bottom-block'>User Coment</div>rtis congue.
																	</div>">
									</div>
							</div>
						</td>
						<td>None</td>
						<td>None</td>
						<td>1/Week</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Erat Situm Gelatis<br></td>
						<td>Avoid</td>
						<td>Avoid</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td>-</td>
					</tr> -->
				</table>
			</div>
		</div>
		<div class="clear"></div>
		<div class="dialog recovery">Recovery status:
			<select id='rec_select'>
			 	<option>0%</option>
			 	<option>10%</option>
			 	<option>20%</option>
			 	<option>30%</option>
			 	<option>40%</option>
			 	<option>50%</option>
			 	<option>60%</option>
			 	<option>70%</option>
			 	<option>80%</option>
			 	<option>90%</option>
			 	<option>100%</option>
		 	</select>
		 	<br>
		 	Your Comment:
			<textarea name='comment'></textarea>
			<div class="btn">
				<a class="delete"></a>
				<a class="save"></a>
			</div>
		</div>
		<div class="dialog assays">Result<span>*</span>:
			<input type="text" id="first-child">
			<select>
				<option>mg</option>
				<option>kg</option>
			</select>
			<input type='text' class="add_item">
			<div class="add"></div><br>
			Reference<span>*</span>:
			<input type="text" id="ref-low"> - <input type="text" id="ref-hi"> = <input type="text"> <br>
			<textarea name='comment'></textarea>
			<span>* Please fill out all required fields</span>
			<div class="clear"></div>
			<div class="btn">
				<a class="delete"></a>
				<a class="cancel"></a>
				<a class="save"></a>
			</div>
		</div>
		<div class="dialog symptom_first">
			<div>Defintion</div>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.
			<div>Find related:</div>
			<a href="" class="message"></a>
			<a href="" class="friends"></a>
			<a href="" class="prof"></a>
			<a href="" class="search"></a>
		</div>

		<div class="dialog symptom">
			<select id="symptom-select">
				<option value="-3">Medium worsening -3</option>	
				<option value="-2">Mild worsening -2</option>
				<option value="-1">Very mild worsening -1</option>
				<option value="0">No change 0)</option>
				<option value="1">Very mild improvement 1</option>
				<option value="2">Mild improvement 2</option>
				<option value="3">Medium improvement 3</option>
			</select><br>
				Your Comment:
			<textarea name='comment'></textarea>
			<div class="btn">
				<a class="delete"></a>
				<a class="save"></a>
			</div>
		</div>
		<div class="dialog diagnoses">Doctor:
			<div class="block_opened_select">
				<select id="country_select" size="5">
					<option>Country</option>
					<option>Usa</option>
					<option>Armenia</option>
					<option>Usbek</option>
					<option>Moscow</option>
					<option>Georgia</option>
				</select>
				<select id="doctor_select" size="4">
					<option data-doctor-id="65">Doctor</option>
					<option data-doctor-id="32">Donals</option>
					<option data-doctor-id="87">Burns</option>
					<option data-doctor-id="12">Michael</option>
					<option data-doctor-id="9">Michael</option>
					<option data-doctor-id="56">Michael</option>
				</select>
			</div>
			<input type="text"><div class="add_doctor">+</div>
			<div class="clear-both"></div>
			Your Comment:
			<textarea name='comment'></textarea>
			<div class="btn">
				<a class="delete"></a>
				<a class="save"></a>
			</div>
		</div>
		<div class="dialog therapies">Dosage<span>*</span>:
			<input type="text" id="first-child">
			<select>
				<option>mg</option>
				<option>kg</option>
			</select><br>
			<div class="every_day_div">every <input type="text" id="second-child">  day</div><br>
			Doctor:
			<div class="block_opened_select">
				<select id="country_select" size="5">
					<option>Country</option>
					<option>Usa</option>
					<option>Armenia</option>
					<option>Usbek</option>
					<option>Moscow</option>
					<option>Georgia</option>
				</select>
				<select id="doctor_select" size="4">
					<option>Doctor</option>
					<option>Donals</option>
					<option>Burns</option>
					<option>Michael</option>
					<option>Michael</option>
					<option>Michael</option>
				</select>
			</div>
			<input type="text"><div class="add_doctor">+</div>
			<label><input type='checkbox' id="self_prescribed">Selft Prescribed</label><br>
			Effect:
			<div class="block_header">
				<div id="left_column_header">Symptom</div>
				<div id="right_column_header">Effect</div>
			</div>
			<div>
				<div class="effect_main_block">
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
				</div>
			</div>
				Your Comment:
			<textarea name='comment'></textarea>
			<div class="btn">
				<a class="delete"></a>
				<a class="save"></a>
			</div>
		</div>
		<div class="dialog lifestyle">Frequency:
			<div class="frequency_main_block">
				<div class="row">
					<label><div class="right_part">1/Day</div>
					Once a day or more<input type="checkbox"></label>
				</div>
				<div class="row">
					<label><div class="right_part">1/Week</div>
					Once a week or more<input type="checkbox"></label>
				</div>
				<div class="row">
					<label><div class="right_part">1/Month</div>
					Once a month or more<input type="checkbox"></label>
				</div>
			</div>
			Effect:
			<div class="block_header">
				<div id="left_column_header">Symptom</div>
				<div id="right_column_header">Effect</div>
			</div>
			<div>
				<div class="effect_main_block">
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
					<div class="row">Symptom1
						<select>
							<option>1</option>
							<option>2</option>
						</select>
					</div>
				</div>
			</div>
				Your Comment:
			<textarea name='comment'></textarea>
			<div class="btn">
				<a class="delete"></a>
				<a class="save"></a>
			</div>
		</div>
	</div>
	<div class="button">
		<a href="" class="delete"></a>
	</div>
	<div class="clear"></div>
</div>
	<!-- <div class="pop-up" id="search">
		<div class="pop-up-inner-block">
			<div class="header_line">
				<div class="header"><p class="searched_word">Results:<span>Testosteron</span></p>
				<div class="icons">
					<div class="topics" title=""></div>
					<div class="posts" title=""></div>
					<div class="search" title=""></div>
				</div>
				</div>
			</div>
			<hr>
			<div class="main_content">
				<div class="bordered_block">
					Testosteron
					<div class="search"></div>
				</div>
				<div class="line">
					<p><span>Result 01</span>-Lorem ipsum dolor sit amet, consectetur adipiscing elit.-Lorem ipsum dolor sit amet,<span class="founded_word">Testosteron</span> consectetur adipiscing elit. -Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p><br/>
					<div class="assay_btn">assays</div><p class="description">10.01.2014</p>
				</div>
			</div>
		</div>
	</div> -->
	<!-- <div class="pop-up" id="details">
		<div class="pop-up-inner-block">
			<div class="header_line">
				<div class="header">Posts</div>
				<div class="icons">
					<div class="topics" title=""></div>
					<div class="posts" title=""></div>
					<div class="search" title=""></div>
				</div>
			</div>
			<hr>
			<div class="main_content">
				<div class="line">
					<div class="left_part">
						<p><span>Topic 6</span>-Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p><br/>
						<p class="description">Posted by <span>Admin,</span> 10.01.2014</p>
					</div>
					<div class="right_part">04 Comments</div>
				</div>
			</div>
		</div>
	</div> -->
	<div class="pop-up" id="error_data_entry" style="display:none;" >
		<div class="pop-up-inner-block">
			<p>Data Entry <b>Error</b></p>
			<p id="esc">[ESC]</p><br><hr>
			<span></span>
		</div>
	</div>
	<!-- <div class="pop-up" id="column_delete">
		<div class="pop-up-inner-block">
			<p>Delete <b>Column</b></p>
			<p>[ESC]</p><br><hr>
			<span>You are about to delete all values of the selected date row(s). This cannot be
			undone! Are you SURE?</span><hr><br>
			<a class="delete_accept"></a>
			<a class="cancel_delete"></a>
		</div>
	</div>  -->
	<!-- <div class="pop-up" id="row_delete">
		<div class="pop-up-inner-block">
			<p>Delete <b>Row</b></p>
			<p>[ESC]</p><br><hr>
			<span>You are about to delete all values of the selected date row(s). This cannot be
			undone! Are you SURE?</span><hr><br>
			<a class="delete_accept"></a>
			<a class="cancel_delete"></a>
		</div>
	</div> -->
<script>
	var id;
	var type;
	var data;
	var index
	var selector_id;

	jQuery( "#accordion,#accordion1" ).accordion({ 
		active: 'false', 
		collapsible: true,
		heightStyle: "content",
		activate: function( event, ui ) {
			jQuery('.dialog').dialog( "close" );
		},
		beforeActivate: function(event, ui) {
	         // The accordion believes a panel is being opened
	         jQuery('.dialog').dialog( "close" );
	        if (ui.newHeader[0]) {
	            var currHeader  = ui.newHeader;
	            var currContent = currHeader.next('.ui-accordion-content');
	         // The accordion believes a panel is being closed
	        } else {
	            var currHeader  = ui.oldHeader;
	            var currContent = currHeader.next('.ui-accordion-content');
	        }
	         // Since we've changed the default behavior, this detects the actual status
	        var isPanelSelected = currHeader.attr('aria-selected') == 'true';

	         // Toggle the panel's header
	        currHeader.toggleClass('ui-corner-all',isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top',!isPanelSelected).attr('aria-selected',((!isPanelSelected).toString()));

	        // Toggle the panel's icon
	        currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e',isPanelSelected).toggleClass('ui-icon-triangle-1-s',!isPanelSelected);

	         // Toggle the panel's content
	        currContent.toggleClass('accordion-content-active',!isPanelSelected)    
	        if (isPanelSelected) { currContent.slideUp(); }  else { currContent.slideDown(); }

	        return false; // Cancel the default action
	    }  
	});

	jQuery('#rec_select,.effect_main_block select').selectbox({
		width: 40,
		onOpen: function (inst) {
			jQuery('.sbToggle.sbToggleOpen').parent().addClass('active');
		},
		onClose: function (inst) {
			jQuery('.sbToggle').parent().removeClass('active');
		},
	});

	jQuery('.main-container select').selectbox({
		customScrollbar: true,
		width: 90,
		sbToggleOpen : false,
		onOpen: function (inst) {
			jQuery('.sbToggle.sbToggleOpen').parent().addClass('active');
		},
		onClose: function (inst) {
			jQuery('.sbToggle').parent().removeClass('active');
		},
	});
	
	jQuery('.sbOptions').jScrollPane({
		showArrows: false,
		autoReinitialise: true,
        autoReinitialiseDelay: 10,
	});

	jQuery('.effect_main_block').parent().jScrollPane();

	jQuery('.rec_status .sbHolder').hover(function(){
		jQuery(this).find('.sbToggle').css('display','block');
    	jQuery(this).css('border','1px solid #eaeaea');
    	jQuery(this).css('background-color','#fff');
    },function(){
		jQuery(this).find('.sbToggle').css('display','none');
    	jQuery(this).css('border','none');
    	jQuery(this).css('background-color','transparent');
    });

	jQuery('#accordion1 label').click(function(event) {
		event.stopPropagation();
		event.preventDefault();
		jQuery( ".dialog" ).dialog({ 
			position: { 
				my: "left+20 bottom-20",
				of: event,
				collision: "none"
			}
		});
		if(jQuery( ".dialog.symptom" ).dialog( "isOpen" )){
			jQuery( ".dialog.symptom" ).dialog( "close" );
		}else{
			jQuery( ".dialog.symptom" ).dialog( "open" );
		}
	});

	jQuery( ".dialog.assays .add" ).click(function(event) {
		event.stopPropagation();
		jQuery('.dialog.assays .sbHolder').css('display','none');
		jQuery('.add_item').css('display','inline-block');
		jQuery('.add').css('background-position','0px -31px');
	});

	jQuery( ".dialog" ).dialog({ 
		autoOpen: false,
		open: function( event, ui ) {
			jQuery( document).tooltip("disable");
		},
		close: function( event, ui ) {
			jQuery( ".comment" ).removeClass("active");
			jQuery( document).tooltip("enable");
		}
	});

	jQuery( ".comment div:first-child" ).hover(function(event) {
		jQuery( this ).parent().addClass('hovered');
		//jQuery( this ).parent().css('border','1px solid #eaeaea !important');
	},function(event) {
		jQuery( this ).parent().removeClass('hovered');
		//jQuery( this ).parent().css('border','1px solid #eaeaea !important');
	});

	jQuery( ".header-line .btn" ).on('click',function(event) {
		event.stopPropagation();
		if ( jQuery( this ).hasClass('active')){
			event.preventDefault();
		}else if(jQuery( this ).hasClass('my')){
			jQuery( this ).addClass('active');
			var tableForAppend = jQuery( this ).data('table');
			jQuery( this ).parent('div').find('.btn.all').removeClass('active');
			jQuery( 'table.'+tableForAppend ).find('tr:last-child').remove();
		}else{
			jQuery( this ).addClass('active');
			var tableForAppend = jQuery( this ).data('table');
			jQuery( this ).parent('div').find('.btn.my').removeClass('active');
			jQuery( 'table.'+tableForAppend ).append("<tr class='add-row'><td><input type='text'><div class='add'></div></td><td class='none'></td><td class='none'></td><td class='none'></td><td class='none'></td><td class='none'></td><td></td></tr> ");
		}
	});

	jQuery( ".comment div:first-child" ).click(function(event) {
		event.stopPropagation();
		jQuery( ".dialog" ).dialog({ 
			position: { 
				my: "left+20 bottom-20",
				of: event,
				collision: "fit flip"
			}
		});
		var dialog_id = jQuery(this).closest('table').attr('class');
		index = jQuery(this).closest('td').index();
		type = dialog_id;

		if (type.indexOf("symptom") > -1) {
			dialog_id = type = 'symptom';
		}

		if(type == 'therapies') {
			Add.addSymptomEffect();
		}

		console.log(dialog_id);
		selector_id = jQuery(this);

		if(jQuery( ".dialog."+dialog_id ).dialog( "isOpen" )){
			jQuery( ".dialog."+dialog_id ).dialog( "close" );
		}else{
			jQuery('.dialog').dialog( "close" );
			jQuery( this ).parent( '.comment' ).addClass('active');
			jQuery( ".dialog."+dialog_id ).dialog( "open" );
		}
	});

	jQuery('.dialog').click(function(event){
		event.stopPropagation();
	});

	jQuery(document).ready(function(){
		jQuery('.dialog.diagnoses').find('.sbHolder').addClass('active');
		jQuery.widget("ui.tooltip", jQuery.ui.tooltip, {
	        options: {
	            content: function () {
	             return jQuery(this).prop('title');
	           }
	             }
	         });
		jQuery( document).tooltip({
			collision: "flipfit",
			position: {
		        my: "left bottom",
		        at: "left-50 top-15",
		        using: function( position, feedback ) {
					jQuery( this ).css( position );
					jQuery( "<div>" )
					.addClass( "arrow" )
					.addClass( feedback.vertical )
					.addClass( feedback.horizontal )
					.appendTo( this );
				}
			}
		});
		jQuery( document ).click(function(event){
			if (event.which == 1) {
				jQuery('.dialog').dialog('close');
			};
		});
	});

	jQuery('.save').on('click', function(){
		Save.savePatientData(type);
	});

	//custom javascript;
	var diagnos_doctor_id;
	var recovery_val;

	jQuery(document).ready(function(){
		Diagnos.setDoctorId();
		Diagnos.filtrDoctorByCountry();
		Add.addNewType();
	});
	

	Save = {

		saveRecovery: function() {
			var dialog = jQuery('.dialog.recovery');

			var recovery = dialog.find('.sbSelector').text();
			recovery_val = parseInt(recovery);

			var current_data = {				
				recovery_id: selector_id.closest('td').data('recovery-id'),
				value: recovery_val, 
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				remarks: dialog.find('textarea').val()				
			};

			var datas = {
				action: type,
		        data: current_data,
		        type: 'set'
			};

			jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
				if(response.status == 4) {
					dialog.dialog( "close" );
					jQuery('#error_data_entry').css('display','block');
				} else {
					console.log(response);
				}
		 	}, 'json');
		 	return false;


			console.log(datas);
		},

		saveSymptom: function() {

			var dialog = jQuery('.dialog.symptom');

			var symptom_val = jQuery("#symptom-select").val();

			var current_data = {
				user_symptom_id: selector_id.closest('td').data('user-symptom-id'),
				symptom_id: selector_id.closest('tr').data('symptom-id'),
				value: symptom_val, 
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				comment: dialog.find('textarea').val()				
			};

			var datas = {
				action: type,
		        data: current_data,
		        type: 'set'
			};

			console.log(datas);

			jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
				if(response.status == 4) {
					dialog.dialog( "close" );
					jQuery('#error_data_entry').css('display','block');
				} else {
					console.log(response);
				}
		 	}, 'json');
		 	return false;
			
		},

		saveAssays: function() {

			var dialog = jQuery('.dialog.assays');

			var current_data = {
				
				assay_id: selector_id.closest('tr').data('assay-id'),
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				unit_id: 2,
				result: dialog.find('#first-child').val(),
				ref_low: dialog.find('#ref-low').val(),
				ref_hi: dialog.find('#ref-hi').val(),
				remarks: dialog.find('textarea').val()				
			};

			var datas = {
				action: type,
		        data: current_data,
		        type: 'set'
			};

			console.log(current_data);

		},

		saveDiagnoses: function() {

			var dialog = jQuery('.dialog.diagnoses');

			var current_data = {
				
				diagnosis_id: selector_id.closest('tr').data('diagnosis-id'),
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				doctor_id: diagnos_doctor_id,
				comment: dialog.find('textarea').val()			
			};
			

			var datas = {
				action: type,
		        data: current_data,
		        type: 'set'
			};

			console.log(current_data);
			// jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
			// 	if(response.status == 4) {
			// 		dialog.dialog( "close" );
			// 		jQuery('#error_data_entry').css('display','block');
			// 	} else {
			// 		console.log(response);
			// 	}
		 // 	}, 'json');
		 // 	return false;
		},

		saveTherapies: function() {
			var dialog = jQuery('.dialog.therapies');
			var prescribed = ( dialog.find("#self_prescribed").is(":checked") ) ? 1 : 0;
			var effect_sel = dialog.find('.row');
			var effect_obj = {};

			jQuery.each(effect_sel, function(){
				effect_obj[jQuery(this).data('symptom-id')] = jQuery(this).find('.sbSelector').text();
			});

			var current_data = {
				
				therapy_id: selector_id.closest('tr').data('therapy-id'),
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				comment: dialog.find('textarea').val(),
				dosage: dialog.find('#first-child').val(),
				frequency: dialog.find('#second-child').val(),
				self_prescribed: prescribed,
				effect: effect_obj,

			};
			console.log(current_data);
		},

		saveLifestyle: function() {
			
		},

		savePatientData: function(type) {
			eval('this.save' + this.ucfirst(type))(type);
		},

		ucfirst:  function(str) {
		  str += '';
		  var f = str.charAt(0).toUpperCase();
		  return f + str.substr(1);
		},
	}	

	Diagnos = {

		setDoctorId: function() {
			jQuery('#doctor_select').next().find('li').on('click', function(){
				var index = jQuery(this).index();
				diagnos_doctor_id = jQuery('#doctor_select').find('option:eq('+index+')').data('doctor-id');
			});
		},

		filtrDoctorByCountry: function() {
			jQuery('#country_select').next().find('li').on('click', function(){
				var index = jQuery(this).index();
				var country = jQuery('#country_select').find('option:eq('+index+')').text();
				var current_data = {
					country: country,
				}
				var datas = {
					action: 'doctor',
			        data: current_data,
			        type: 'get'
				};
				console.log(current_data);
				// jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
				// 	alert(response);
		 	// 	}, 'json');
			});
		}
	}
	
	Add = {

		addSymptomEffect: function() {
			var symptom_ids = {};
			var obj = jQuery('table.symptom');
			jQuery.each(obj,function(){
				jQuery.each(jQuery(this).find('tr'), function(){
					if(jQuery(this).find('td:eq('+index+')').text() != '-'){
						symptom_ids[jQuery(this).data('symptom-id')] = jQuery(this).find('td:eq(0)').text();
					}
				});
			});
			var effect = '';
			jQuery.each(symptom_ids, function(key,value){
				
				effect = effect + '<div data-symptom-id='+key+' class="row">'+value+'<select><option>1</option><option>2</option></select></div>';
			});

			jQuery('.effect_main_block').empty().append(effect);
			jQuery('#rec_select,.effect_main_block select').selectbox({
				width: 40,
				onOpen: function (inst) {
					jQuery('.sbToggle.sbToggleOpen').parent().addClass('active');
				},
				onClose: function (inst) {
					jQuery('.sbToggle').parent().removeClass('active');
				},
			});

			jQuery('.main-container select').selectbox({
				customScrollbar: true,
				width: 90,
				sbToggleOpen : false,
				onOpen: function (inst) {
					jQuery('.sbToggle.sbToggleOpen').parent().addClass('active');
				},
				onClose: function (inst) {
					jQuery('.sbToggle').parent().removeClass('active');
				},
			});
			
			jQuery('.sbOptions').jScrollPane({
				showArrows: false,
				autoReinitialise: true,
		        autoReinitialiseDelay: 10,
			});

		},

		addNewType: function(){
			jQuery('.add-row').find('.add').live('click', function(){
				var closest_tbody = jQuery(this).closest('tbody')
				var add_type = jQuery(this).closest('table').attr('class');
				var current_data = {};
				if (add_type.indexOf("symptom") > -1) {
					add_type = 'symptom';
					current_data.symptom_category_id = jQuery(this).closest('table').prev().data('category-id');
				}
				current_data.name = jQuery(this).prev().val();

				var datas = {
					action: add_type,
					data: current_data,
					type: 'add'
				};

				jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
					if(response.status == 4) {
						dialog.dialog( "close" );
						jQuery('#error_data_entry').css('display','block');
					} else {
						console.log(response);
						closest_tbody.find('.add-row').before('<tr data-'+add_type+'-id="'+response.id+'" style="display:none;"><td><input type="checkbox"><label>'+current_data.name+'</label></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>');
						closest_tbody.find('.add-row').prev().fadeIn(1500);
					}
			 	}, 'json');
			 	return false;

				console.log(datas);

			});
		},
	}	

	jQuery('#esc').on('click', function(){
		jQuery('.pop-up').css('display','none');
		setTimeout(function(){
			jQuery('.dialog.'+type).dialog( "open" );
		},50);		
	});
	

</script>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>

<?php
	function validDate($date) {
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
	        return true;
	    } else {
	        return false;
	    }
	}
?>
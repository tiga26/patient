<?php
/*
 * Template Name: Patient Statistics
 */

require_once dirname(__FILE__).'/../class-db-manager.php';
global $wp;
global $bp;

if(validDate($_GET['start_date']) && validDate($_GET['end_date'])) {
	$dates['start'] = $_GET['start_date'];
	$dates['end'] = $_GET['end_date'];
} else {
	$dates = array();
}

$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );

$patient = new Patient_Db_Manager();
// echo '<pre>';
$patient_data = $patient->setPatient(wp_get_current_user()->ID)
						->loadPatientAllData($dates)
						->getPatientData();
// var_dump('dates',$patient_data->scheduler);
// echo '<br>';
// echo '<br>';
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
// var_dump('therapies',$patient_data->lifestyle);
// echo '<br>';
// echo '<br>';
// var_dump('lifestyle',$patient_data->effects);
// exit;

get_header();
?>
<div id="fade">
	<div class="loader">
		<div class="spinner">
		  <div class="spinner-container container1">
		    <div class="circle1"></div>
		    <div class="circle2"></div>
		    <div class="circle3"></div>
		    <div class="circle4"></div>
		  </div>
		  <div class="spinner-container container2">
		    <div class="circle1"></div>
		    <div class="circle2"></div>
		    <div class="circle3"></div>
		    <div class="circle4"></div>
		  </div>
		  <div class="spinner-container container3">
		    <div class="circle1"></div>
		    <div class="circle2"></div>
		    <div class="circle3"></div>
		    <div class="circle4"></div>
		  </div>
		</div>
	</div>
</div>
<canvas id="myChart" width="1200px;" height="200"></canvas>
<div id="slider"></div>
 
<div id="info" style="position:absolute; background:#267893; z-index:9999; width:60px;opacity:0.8; display:none;color:#fff">
	<div id="infoDays">Days 0</div>
	<div id="infoProcents">0%</div>
</div>
<div class="main-container">
	
	<?php $dates_array = array_values($patient_data->dates);?>
	<div>
	 	<div class="top_table_block">
		 	<table class="recovery">
		 		<tr class="dates">		 			
		 			<td id='dates'><span style="line-height:25px;">Dates</span><button type="button" id="add-date" class="btn btn-primary btn-xs" style="width:38px;height:25px;font-size:12px;float:right;margin-right:5px;display:none;">Add</button><input class="datepicker" data-date-format="yyyy-dd-mm" style="width:75px; height:25px;font-size:12px;line-height: normal;float:right;margin-right:5px;display:none;color:#333333"><div id="right-date" style="width:65px;height:25px;float:right"><button type="button" id="add-date-button" class="btn btn-primary btn-xs" style="width:65px;height:25px;font-size:12px;float:right;margin-right:5px;">Add Date</button></div></td>   		        
		 			<?php foreach ($patient_data->dates as $date) : ?>
		 				<td data-relation-id="<?php echo $date->relation_id;?>"><input type="checkbox"><?php echo $date->date;?></td>
		 			<?php endforeach;?>
		 			<?php if(count($patient_data->dates) < 6):?>
		 				<?php $empty_dates_cnt = 6 - count($patient_data->dates);?>
		 				<?php for ($i=0; $i < $empty_dates_cnt; $i++) :?> 
		 					<td>-</td>
		 				<?php endfor;?>
		 			<?php endif;?>
		 		</tr>
		 		<tr class="rec_status">
		 			<td>Recovery Status</td>
		 			<?php foreach ($patient_data->recovery as $relation_id => $recovery) : ?>
		 				<?php if(empty($recovery) && !empty($patient_data->dates[$relation_id])):?>
		 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
	 					<?php elseif (empty($recovery) && empty($patient_data->dates[$relation_id])): ?>
	 						<td>-</td>
		 				<?php else: ?>
		 					<td data-recovery-id="<?php echo $recovery->recovery_id;?>" data-comment="<?php echo $recovery->remarks;?>" data-value="<?php echo $recovery->value;?>">
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
		 							<?php $check_date = array_key_exists(array_search($symptom_id, array_keys($symptom_array)),$dates_array);?>
					 				<?php if(empty($symptom)  && $check_date): ?>
					 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
					 				<?php elseif(empty($symptom) && !$check_date):?>
					 					<td>-</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>" data-value="<?php echo $symptom->value;?>" data-comment="<?php echo $symptom->comment;?>">
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
		 							<?php $check_date = array_key_exists(array_search($symptom_id, array_keys($symptom_array)),$dates_array);?>
					 				<?php if(empty($symptom) && $check_date): ?>
					 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
				 					<?php elseif(empty($symptom) && !$check_date): ?>
				 						<td>-</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>" data-value="<?php echo $symptom->value;?>" data-comment="<?php echo $symptom->comment;?>">
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
					 				<?php $check_date = array_key_exists(array_search($symptom_id, array_keys($symptom_array)),$dates_array);?>
					 				<?php if(empty($symptom) && $check_date): ?>
					 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
				 					<?php elseif(empty($symptom) && !$check_date): ?>
				 						<td>-</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>" data-value="<?php echo $symptom->value;?>" data-comment="<?php echo $symptom->comment;?>">
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
					 				<?php $check_date = array_key_exists(array_search($symptom_id, array_keys($symptom_array)),$dates_array);?>
					 				<?php if(empty($symptom) && $check_date): ?>
					 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
				 					<?php elseif(empty($symptom) && !$check_date): ?>
				 						<td>-</td>
					 				<?php else: ?>
							 			<td data-user-symptom-id="<?php echo $symptom->user_symptom_id;?>" data-value="<?php echo $symptom->value;?>" data-comment="<?php echo $symptom->comment;?>">
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
				 				<?php $check_date = array_key_exists(array_search($assay_id, array_keys($assay_array)),$dates_array);?>
				 				<?php if(empty($assay) && $check_date): ?>
				 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
			 					<?php elseif(empty($assay) && !$check_date): ?>
			 						<td>-</td>
				 				<?php else: ?>
						 			<td data-assay-result-id="<?php echo $assay->assay_result_id;?>" data-result="<?php echo $assay->result;?>" data-ref-low="<?php echo $assay->ref_low;?>" data-ref-hi="<?php echo $assay->ref_hi;?>" data-ref-percent="<?php echo $assay->ref_percent;?>" data-remarks="<?php echo $assay->remarks;?>">
						 				<div class="comment">
						 					<div><?php echo $assay->result;?></div>
						 					<div class="comment_icon" title="<div class='comment_block'>
						 														<div>Result<span>*</span>:</div><div class='value'><?php echo $assay->result;?>mg</div>
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
	 							<?php $check_date = array_key_exists(array_search($diagnosis_id, array_keys($diagnosis_array)),$dates_array);?>
				 				<?php if(empty($diagnos) && $check_date): ?>
				 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
			 					<?php elseif(empty($diagnos) && !$check_date): ?>
			 						<td>-</td>
				 				<?php else: ?>
						 			<td data-doctor-diagnosis-id="<?php echo $diagnos->doctor_diagnosis_id;?>" data-doctor-id="<?php echo $diagnos->doctor_id;?>" data-doc-name="<?php echo $diagnos->doc_name;?>" data-comment="<?php echo $diagnos->comment;?>">
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
				 				<?php $check_date = array_key_exists(array_search($therapy_id, array_keys($therapies_array)),$dates_array);?>
				 				<?php if(empty($therapy) && $check_date): ?>
				 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
			 					<?php elseif(empty($therapy) && !$check_date): ?>
			 						<td>-</td>
				 				<?php else: ?>
						 			<td data-therapy-result-id="<?php echo $therapy->therapy_result_id;?>" data-dosage="<?php echo $therapy->dosage;?>" data-frequency="<?php echo $therapy->frequency;?>" data-doc-name="<?php echo $therapy->doc_name;?>" data-doctor-id="<?php echo $therapy->doctor_id;?>" data-self-prescribed="<?php echo $therapy->self_prescribed;?>" data-effect='<?php echo json_encode($patient_data->effects['therapy'][$therapy->therapy_result_id]); ?>' data-comment="<?php echo $therapy->comment;?>">
						 				<div class="comment">
						 					<div><?php echo $therapy->dosage;?>ml/<?php echo $therapy->frequency;?></div>
						 					<div class="comment_icon" title="<div class='comment_block'>
						 													 	<div>Dosage:</div><div class='value'><?php echo $therapy->dosage;?>ml every <?php echo $therapy->frequency;?> day</div>
						 													 	<div>Doctor:</div><div class='value'>Dr. <?php echo $therapy->doc_name;?>,<?php echo $therapy->country;?></div>						 													 	
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
								 													 		<?php foreach ($patient_data->effects['therapy'][$therapy->therapy_result_id] as $effect):?>								 													 	
								 													 			<div class='row'><div class='text'><?php echo $effect->name;?></div><div class='value'><?php echo $effect->value;?></div></div>								 													 		
									 			 										 	<?php endforeach;?>
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
				<div class="first-child">Lyfestyle</div><div class="btn my active" data-table='lifestyle'>my lifestyle</div><div class="btn all" data-table='lifestyle'>all lifestyle</div>
			</div>
			<div>
				<table class="lifestyle">
					<?php foreach ($patient_data->lifestyle as $lifestyle_id => $lifestyles_array) : ?>
 						<?php $tmp_lifestyle = current(array_filter($lifestyles_array));?>
 						<?php $lifestyle_name = $tmp_lifestyle->name;?>
 						<tr data-lifestyle-id="<?php echo $lifestyle_id;?>">
	 						<td><input type="checkbox"><label><?php echo $lifestyle_name;?></label></td>
	 						<?php foreach ($lifestyles_array as $lifestyle_id => $lifestyle):?>
				 				<?php $check_date = array_key_exists(array_search($lifestyle_id, array_keys($lifestyles_array)),$dates_array);?>
				 				<?php if(empty($lifestyle) && $check_date): ?>
				 					<td><div class="comment no-data"><div>-</div><div class="comment_icon"></div></div></td>
			 					<?php elseif(empty($lifestyle) && !$check_date): ?>
			 						<td>-</td>
				 				<?php else: ?>
						 			<td data-lifestyle-result-id="<?php echo $lifestyle->lifestyle_result_id;?>" data-frequency-id="<?php echo $lifestyle->lifestyle_frequency_id;?>" data-comment="<?php echo $lifestyle->comment;?>" data-effect='<?php echo json_encode($patient_data->effects['lifestyle'][$lifestyle->lifestyle_result_id]); ?>'>
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
								 													 		<?php foreach ($patient_data->effects['lifestyle'][$lifestyle->lifestyle_result_id] as $effect):?>								 													 	
								 													 			<div class='row'><div class='text'><?php echo $effect->name;?></div><div class='value'><?php echo $effect->value;?></div></div>								 													 		
									 			 										 	<?php endforeach;?>
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
			<input type="text" id="ref-low"> - <input type="text" id="ref-hi"> = <input type="text" id="ref-percent" disabled> <br>
			<textarea name='comment'></textarea>
			<span>* Please fill out all required fields</span>
			<div class="clear"></div>
			<div class="btn">
				<a class="delete"></a>
				<!-- <a class="cancel"></a> -->
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
			<span style="vertical-align:middle;">Symptom Severity:</span>
			<select id="symptom-select">
				<option value="-3">Medium worsening -3</option>	
				<option value="-2">Mild worsening -2</option>
				<option value="-1">Very mild worsening -1</option>
				<option value="0">No change 0</option>
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
				<select class="country_select" size="5">
					<?php foreach ($patient_data->country as $country): ?>
						<option><?php echo $country->country;?></option>
					<?php endforeach;?>
				</select>
				<select class="doctor_select" size="4">
					<?php foreach($patient_data->doctors as $doctor):?>
						<option data-doctor-id="<?php echo $doctor->doctor_id;?>"><?php echo $doctor->name;?></option>
					<?php endforeach;?>
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
				<select class="country_select" size="5">
					<?php foreach ($patient_data->country as $country): ?>
						<option><?php echo $country->country;?></option>
					<?php endforeach;?>
				</select>
				<select class="doctor_select" size="4">
					<?php foreach($patient_data->doctors as $doctor):?>
						<option data-doctor-id="<?php echo $doctor->doctor_id;?>"><?php echo $doctor->name;?></option>
					<?php endforeach;?>
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
				<div class="row" data-lifestyle-frequency-id="1">
					<label><div class="right_part">1/Day</div>
					Once a day or more<input type="checkbox"></label>
				</div>
				<div class="row" data-lifestyle-frequency-id="2">
					<label><div class="right_part">1/Week</div>
					Once a week or more<input type="checkbox"></label>
				</div>
				<div class="row" data-lifestyle-frequency-id="3">
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
	var selected_date;
	
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
		jQuery('.dialog.assays .add').css('background-position','0px -31px');
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
			All.removeAll(tableForAppend);
			jQuery( this ).parent('div').find('.btn.all').removeClass('active');
			// jQuery( 'table.'+tableForAppend ).find('tr:last-child').remove();
		}else{
			jQuery( this ).addClass('active');
			var tableForAppend = jQuery( this ).data('table');
			All.addAll(tableForAppend);
			jQuery( this ).parent('div').find('.btn.my').removeClass('active');			
		}
	});

	jQuery( ".comment div:first-child" ).live('click',function(event) {
		event.stopPropagation();
		jQuery('input').css('border-color','#EAEAEA');

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

		if(type == 'therapies' || type == 'lifestyle') {
			Add.addSymptomEffect();
			jQuery('.frequency_main_block').css('border-color','#267893');
		}

		
		if(jQuery(this).parent().hasClass('no-data')) {			
			jQuery('.dialog.' + type).find('.delete').css('display','none');
		} else {
			jQuery('.dialog.' + type).find('.delete').css('display','block');
		}

		Diagnos.setDoctorId();
		Diagnos.filtrDoctorByCountry();
		selector_id = jQuery(this);
		Fill.fillDialogData(type);

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

	var diagnos_doctor_id;
	var recovery_val;

	jQuery(document).ready(function(){
		Add.addNewType();

		jQuery('.dialog .delete').on('click' , function(){
			Delete.deleteSingleData();
		});

	});
	

	Save = {

		saveRecovery: function() {
			jQuery('#info').hide();
			jQuery('#fade').show();
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

				}
				location.reload();

		 	}, 'json');

		 	return false;

		},

		saveSymptom: function() {
			jQuery('#info').hide();
			jQuery('#fade').show();
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

			jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
				if(response.status == 4) {
					dialog.dialog( "close" );
					jQuery('#error_data_entry').css('display','block');
				} else {

				}
				location.reload();

		 	}, 'json');
		 	return false;
			
		},

		saveAssays: function() {
			jQuery('#info').hide();
			jQuery('#fade').show();
			var dialog = jQuery('.dialog.assays');
			var validate = true;

			var current_data = {
				
				assay_id: selector_id.closest('tr').data('assay-id'),
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				unit_id: 2,
				result: dialog.find('#first-child').val(),
				ref_low: dialog.find('#ref-low').val(),
				ref_hi: dialog.find('#ref-hi').val(),
				remarks: dialog.find('textarea').val()				
			};

			if(current_data.result == '') {
				dialog.find('#first-child').css('border-color','#F31A1A');
				validate = false;
			}

			if(current_data.ref_low == '') {
				dialog.find('#ref-low').css('border-color','#F31A1A');
				validate = false;
			}

			if(current_data.ref_hi == '') {
				dialog.find('#ref-hi').css('border-color','#F31A1A');
				validate = false;
			}

			if(validate == false) {
				return false;
			}

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

				}
				location.reload();

		 	}, 'json');

		},

		saveDiagnoses: function() {
			jQuery('#info').hide();
			jQuery('#fade').show();
			var dialog = jQuery('.dialog.diagnoses');

			var current_data = {
				
				diagnosis_id: selector_id.closest('tr').data('diagnosis-id'),
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				doctor_id: diagnos_doctor_id,
				comment: dialog.find('textarea').val(),	
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

				}
				location.reload();

		 	}, 'json');
		 	return false;
		},

		saveTherapies: function() {
			jQuery('#info').hide();
			jQuery('#fade').show();
			var dialog = jQuery('.dialog.therapies');
			var prescribed = ( dialog.find("#self_prescribed").is(":checked") ) ? 1 : 0;
			var effect_sel = dialog.find('.row');
			var effect_obj = {};

			var validate = true;

			jQuery.each(effect_sel, function(){
				effect_obj[jQuery('table.symptom').find('[data-symptom-id='+jQuery(this).data('symptom-id')+']').find('td:eq('+index+')').data('user-symptom-id')] = jQuery(this).find('.sbSelector').text();
			});

			var current_data = {
				therapy_result_id: selector_id.closest('td').data('therapy-result-id'),
				therapy_id: selector_id.closest('tr').data('therapy-id'),
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				comment: dialog.find('textarea').val(),
				dosage: dialog.find('#first-child').val(),
				frequency: dialog.find('#second-child').val(),
				self_prescribed: prescribed,
				effect: effect_obj,
				doctor_id: diagnos_doctor_id,

			};

			if(current_data.dosage == '') {
				dialog.find('#first-child').css('border-color','#F31A1A');
				validate = false;
			}

			if(current_data.frequency == '') {
				dialog.find('#second-child').css('border-color','#F31A1A');
				validate = false;
			}

			if(validate == false) {
				return false;
			}

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

				}
				location.reload();

		 	}, 'json');
		 	return false;

			
		},

		saveLifestyle: function() {
			jQuery('#info').hide();
			jQuery('#fade').show();
			var dialog = jQuery('.dialog.lifestyle');
			var effect_sel = dialog.find('.effect_main_block .row');
			var effect_obj = {};
			var frequency_select = dialog.find('.frequency_main_block .row'); 
			var lifestyle_frequency_id;

			var validate = false;

			jQuery.each(frequency_select, function(){
				if(jQuery(this).find('input').is(":checked")) {
					validate = true;
					lifestyle_frequency_id = jQuery(this).data('lifestyle-frequency-id');
					return false;
				}
			});

			if(validate == false) {
				dialog.find('.frequency_main_block').css('border-color','#F31A1A');
				return false;
			}

			jQuery.each(effect_sel, function(){
				effect_obj[jQuery('table.symptom').find('[data-symptom-id='+jQuery(this).data('symptom-id')+']').find('td:eq('+index+')').data('user-symptom-id')] = jQuery(this).find('.sbSelector').text();
			});
			
			var current_data = {
				lifestyle_result_id: selector_id.closest('td').data('lifestyle-result-id'),
				lifestyle_id: selector_id.closest('tr').data('lifestyle-id'),
				lifestyle_frequency_id: lifestyle_frequency_id,
				relation_id: jQuery('.dates').find('td:eq('+index+')').data('relation-id'),
				comment: dialog.find('textarea').val(),
				effect: effect_obj,				
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

				}
				location.reload();

		 	}, 'json');
		 	return false;
			
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

	Delete = {

		deleteDate: function() {
			console.log('date');
		},

		deleteRow: function(type) {
			console.log(type);
		},

		deleteSingleData: function() {
			jQuery('#fade').show();
			jQuery('.dialog').dialog( "close" );
			type_to_data = {
				recovery : 'recovery-id',
				symptom : 'user-symptom-id',
				assays : 'assay-result-id',
				diagnoses : 'doctor-diagnosis-id',
				therapies : 'therapy-result-id',
				lifestyle : 'lifestyle-result-id',
			}

			var data_id = eval('type_to_data.' + type);
			var deleting_id = selector_id.closest('td').data(data_id);
			var index = selector_id.closest('td').index();

			var datas = {
				action: type,
		        data: deleting_id,
		        type: 'delete'
			};

			jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
				jQuery('#fade').hide();
				if(response == '1') {
					selector_id.closest('td').remove();
					index = index - 1;
					if(type != 'recovery') {
						jQuery('.'+type+'').find('td:eq('+index+')').after("<td><div class='comment no-data'><div>-</div><div class='comment_icon'></div></div></td>");
					} else {
						jQuery('.'+type+'').find('.rec_status').find('td:eq('+index+')').after("<td><div class='comment no-data'><div>-</div><div class='comment_icon'></div></div></td>");
					}
					

					jQuery( ".comment div:first-child" ).hover(function(event) {
					jQuery( this ).parent().addClass('hovered');
					},function(event) {
						jQuery( this ).parent().removeClass('hovered');
					});
				}			

		 	}, 'json');
		 	return false;

		}

	}

	Fill = {
		fillRecovery: function() {
			var value = selector_id.closest('td').data('value');
			var comment = selector_id.closest('td').data('comment');
			if(value == undefined) {
				value = '0';
			}
			if(comment == undefined) {
				comment = '';
			}

			jQuery('.dialog.recovery').find('.sbSelector').text(value+'%');
			jQuery('.dialog.recovery').find('textarea').text(comment);
		},

		fillSymptom: function() {
			var value = selector_id.closest('td').data('value');
			var comment = selector_id.closest('td').data('comment');
			
			comment = (comment != undefined) ? comment : '';

			var name;

			var value_obj = {
				0: {
					value : '-2',
					name : 'Mild worsening'

				},
				1: {
					value : '-1',
					name : 'Very mild worsening'

				},
				2: {
					value : '0',
					name : 'No change'

				},
				3: {
					value : '1',
					name : 'Very mild improvement'

				},
				4: {
					value : '2',
					name : 'Mild improvement'

				},
				5: {
					value : '3',
					name : 'Medium improvement'
				},
				6: {
					value : '-3',
					name : 'Medium worsening'
				}

			}

			jQuery.each(value_obj, function(index, symptom){
				if(parseInt(symptom.value) == value) {
					name = symptom.name;
				}
			});
			
			name = (name != undefined) ? name : 'No change';

			jQuery('.dialog.symptom').find('.sbSelector').text(name);
			jQuery('.dialog.symptom').find('textarea').text(comment);

		},

		fillAssays: function() {
			var result = selector_id.closest('td').data('result');
			var ref_low = selector_id.closest('td').data('ref-low');
			var ref_hi = selector_id.closest('td').data('ref-hi');
			var ref_percent = selector_id.closest('td').data('ref-percent');
			var comment = selector_id.closest('td').data('remarks');

			result = (result != undefined) ? result : '';
			ref_low = (ref_low != undefined) ? ref_low : '';
			ref_hi = (ref_hi != undefined) ? ref_hi : '';
			ref_percent = (ref_percent != undefined) ? ref_percent : '';
			comment = (comment != undefined) ? comment : ''; 

			jQuery('.dialog.assays').find('#first-child').val(result);
			jQuery('.dialog.assays').find('#ref-low').val(ref_low);
			jQuery('.dialog.assays').find('#ref-hi').val(ref_hi);
			jQuery('.dialog.assays').find('#ref-percent').val(ref_percent);
			jQuery('.dialog.assays').find('textarea').text(comment);
		},

		fillDiagnoses: function() {
			var doctor_id = selector_id.closest('td').data('doctor-id');
			var doc_name = selector_id.closest('td').data('doc-name');
			var comment = selector_id.closest('td').data('comment');

			doc_name = (doc_name != undefined) ? doc_name : '';
			comment = (comment != undefined) ? comment : '';

			jQuery('.dialog.diagnoses').find('.sbSelector').text(doc_name);
			jQuery('.dialog.diagnoses').find('textarea').text(comment);
		},

		fillTherapies: function() {
			var dosage = selector_id.closest('td').data('dosage');
			var frequency = selector_id.closest('td').data('frequency');			
			var doctor_id = selector_id.closest('td').data('doctor-id');
			var doc_name = selector_id.closest('td').data('doc-name');			
			var self_prescribed = selector_id.closest('td').data('self-prescribed');
			var effects = selector_id.closest('td').data('effect');
			var comment = selector_id.closest('td').data('comment');

			self_prescribed = (self_prescribed != undefined) ? self_prescribed : 0;
			comment = (comment != undefined) ? comment : '';

			jQuery('.dialog.therapies').find('#first-child').val(dosage);
			jQuery('.dialog.therapies').find('#second-child').val(frequency);
			jQuery('.dialog.therapies').find('.doctor_select').next().find('.sbSelector').text(doc_name);

			if(self_prescribed == 1) {
				jQuery('.dialog.therapies').find('#self_prescribed').prop('checked',true);
			}

			var effect_block = jQuery('.dialog.therapies').find('.effect_main_block .row');

			if(effects != undefined) {
				effect_block.each(function(index){
					jQuery(this).find('.sbSelector').text(effects[index].value);
				});	
			}
			
			jQuery('.dialog.therapies').find('textarea').text(comment);
		},

		fillLifestyle: function() {
			var frequency_id = selector_id.closest('td').data('frequency-id');
			var effects = selector_id.closest('td').data('effect');
			var comment = selector_id.closest('td').data('comment');

			comment = (comment != undefined) ? comment : '';

			jQuery('.dialog.lifestyle').find('.frequency_main_block').find('input').prop('checked', false);

			var frequency_block = jQuery('.dialog.lifestyle').find('.frequency_main_block .row');

			frequency_block.each(function() {
				if(jQuery(this).data('lifestyle-frequency-id') == frequency_id) {
					jQuery(this).find('input').prop('checked',true);
				}
			});

			var effect_block = jQuery('.dialog.lifestyle').find('.effect_main_block .row');

			if(effects != undefined) {
				effect_block.each(function(index){
					jQuery(this).find('.sbSelector').text(effects[index].value);
				});
			}

			jQuery('.dialog.lifestyle').find('textarea').text(comment);
		},

		fillDialogData: function(type) {
			eval('this.fill' + this.ucfirst(type))(type);
		},

		ucfirst:  function(str) {
		  str += '';
		  var f = str.charAt(0).toUpperCase();
		  return f + str.substr(1);
		},
	}

	Diagnos = {

		setDoctorId: function() {
			
			jQuery('.dialog.'+type+' .doctor_select').next().find('li').on('click', function(){
				var index = jQuery(this).index();
				diagnos_doctor_id = jQuery('.dialog.'+type+' .doctor_select').find('option:eq('+index+')').data('doctor-id');
				return false;
			});
		},

		filtrDoctorByCountry: function() {
			
			var doctor_select = jQuery('.dialog.'+type+' .doctor_select');
			var country_select = jQuery('.dialog.'+type+' .country_select');
			country_select.next().find('li').on('click', function(){
				var index = jQuery(this).index();
				var country = jQuery('.dialog.'+type+' .country_select').find('option:eq('+index+')').text();

				var current_data = {
					country: country,
				}
				var datas = {
					action: 'doctor',
			        data: current_data,
			        type: 'get'
				};
				
				jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
					
					doctor_select.find('option').remove();
					doctor_select.next().find('li').remove();
					jQuery.each(response,function(insex,doctor){
						doctor_select.append('<option data-doctor-id='+doctor.doctor_id+'>'+doctor.name+'</option>');
						doctor_select.next().find('.jspPane').append('<li><a href=#'+doctor.name+' rel='+doctor.name+' class="">'+doctor.name+'</a></li>');
					});					
					Diagnos.setDoctorId();

					// alert(response);
		 		}, 'json');

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
				
				effect = effect + '<div data-symptom-id='+key+' class="row"><div class="text">'+value+'</div><select><option>1</option><option>2</option></select></div>';
			});

			jQuery('.effect_main_block').empty().append(effect);

			All.restructureSelect();			

		},

		addNewType: function(){
			
			jQuery('.add-row').find('.add').live('click', function(){
				jQuery('#fade').show();
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
						var dates = jQuery('.dates td');
						var cnt = 0;
						dates.each(function(){
							if(jQuery(this).data('relation-id') != undefined) {
								cnt++;
							}
						});					
							
						var add_td = "<td><div class='comment no-data'><div>-</div><div class='comment_icon'></div></div></td>";
						var add_td_empty = "<td>-</td>";
						var add_td_str = "";
						
						for (var i = 0; i < cnt; i++) {
							add_td_str = add_td_str + add_td;
						};

						for (var i = 0; i < 6 - cnt; i++) {
							add_td_str = add_td_str + add_td_empty;
						};

						jQuery('#fade').hide();
						closest_tbody.find('.add-row').before('<tr data-'+add_type+'-id="'+response.id+'" style="display:none;"><td><input type="checkbox"><label>'+current_data.name+'</label></td>'+add_td_str+'</tr>');
						closest_tbody.find('.add-row').prev().fadeIn(1500);

						jQuery( ".comment div:first-child" ).hover(function(event) {
							jQuery( this ).parent().addClass('hovered');
						},function(event) {
							jQuery( this ).parent().removeClass('hovered');
						});
					}
			 	}, 'json');
			 	return false;

			});
		},
	}

	All = {

		restructureSelect: function() {
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

		removeAll: function(type) {
			var data = {
				symptom : 'user-symptom-id',
				assays : 'assay-result-id',
				diagnoses : 'doctor-diagnosis-id',
				therapies : 'therapy-result-id',
				lifestyle : 'lifestyle-result-id',
			}
			var data_attr = eval('data.' + type);			

			jQuery( 'table.'+type).find('tbody').find('tr').each(function() {
				var is_user_data = false;
				jQuery(this).find('td').each(function(){
					if(jQuery(this).data(data_attr) != undefined) {
						is_user_data = true;
						return false;
					}					
				});
				if(is_user_data == false) {
					jQuery(this).remove();		
				}
			});
		},

		addAll: function(type) {
			jQuery('#fade').show();
			var dates = jQuery('.dates td');
			var cnt = 0;

			dates.each(function(){
				if(jQuery(this).data('relation-id') != undefined) {
					cnt++;
				}
			});

			var datas = {
				action: type,
				type: 'getall'
			};
			
			jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
				jQuery('#fade').hide();
				var add_td = "<td><div class='comment no-data'><div>-</div><div class='comment_icon'></div></div></td>";
				var add_td_empty = "<td>-</td>";
				var add_td_str = "";
				
				for (var i = 0; i < cnt; i++) {
					add_td_str = add_td_str + add_td;
				};

				for (var i = 0; i < 6 - cnt; i++) {
					add_td_str = add_td_str + add_td_empty;
				};
				
				switch(type) {					
					case 'symptom':					
						response.mental.forEach(function(mental){
							jQuery( '#accordion' ).find('[data-category-id=1]').next().append("<tr data-symptom-id="+mental.symptom_id+"><td><input type='checkbox'><label>"+mental.name+"</label></td>"+add_td_str+"</tr>");
						});
						response.sexual.forEach(function(sexual){
							jQuery( '#accordion' ).find('[data-category-id=2]').next().append("<tr data-symptom-id="+sexual.symptom_id+"><td><input type='checkbox'><label>"+sexual.name+"</label></td>"+add_td_str+"</tr>");
						});
						response.physical.forEach(function(physical){
							jQuery( '#accordion' ).find('[data-category-id=3]').next().append("<tr data-symptom-id="+physical.symptom_id+"><td><input type='checkbox'><label>"+physical.name+"</label></td>"+add_td_str+"</tr>");
						});
						response.hormonal.forEach(function(hormonal){
							jQuery( '#accordion' ).find('[data-category-id=4]').next().append("<tr data-symptom-id="+hormonal.symptom_id+"><td><input type='checkbox'><label>"+hormonal.name+"</label></td>"+add_td_str+"</tr>");
						});
					break;
					case 'assays':
						response.forEach(function(assay){
							jQuery( 'table.'+type ).append("<tr data-assay-id="+assay.assay_id+"><td><input type='checkbox'><label>"+assay.name+"</label></td>"+add_td_str+"</tr>");
						});
					break;
					case 'diagnoses':
						response.forEach(function(diagnos){
							jQuery( 'table.'+type ).append("<tr data-diagnosis-id="+diagnos.diagnosis_id+"><td><input type='checkbox'><label>"+diagnos.name+"</label></td>"+add_td_str+"</tr>");
						});
					break;
					case 'therapies':
						response.forEach(function(therapy){
							jQuery( 'table.'+type ).append("<tr data-therapy-id="+therapy.therapy_id+"><td><input type='checkbox'><label>"+therapy.name+"</label></td>"+add_td_str+"</tr>");
						});
					break;
					case 'lifestyle':
						response.forEach(function(lifestyle){
							jQuery( 'table.'+type ).append("<tr data-lifestyle-id="+lifestyle.lifestyle_id+"><td><input type='checkbox'><label>"+lifestyle.name+"</label></td>"+add_td_str+"</tr>");
						});
					break;
				}
				jQuery( 'table.'+type).append("<tr class='add-row'><td><input type='text'><div class='add'></div></td><td class='none'></td><td class='none'></td><td class='none'></td><td class='none'></td><td class='none'></td><td></td></tr> ");

				jQuery( ".comment div:first-child" ).hover(function(event) {
					jQuery( this ).parent().addClass('hovered');
				},function(event) {
					jQuery( this ).parent().removeClass('hovered');
				});
		 	}, 'json');
		},
	}

	jQuery('#esc').on('click', function(){
		jQuery('.pop-up').css('display','none');
		setTimeout(function(){
			jQuery('.dialog.'+type).dialog( "open" );
		},50);		
	});
	

</script>

<script>
jQuery(document).ready(function () {

	var date_picker = jQuery('.datepicker').datepicker({
		    startDate: '-3d'
		}).on('changeDate', function(ev){
		  	date_picker.datepicker('hide');
		  	var date = new Date(date_picker.datepicker('getDate').valueOf());
		  	var year = date.getFullYear();
		  	var month = date.getMonth() + 1;
		  	var day = date.getDate();
		  	if(day < 10) {
		  		day = "0"+day;
		  	}
		  	if(month < 10) {
		  		month = "0"+month;
		  	}
		  	selected_date = year+'-'+month+'-'+day;
	});

	jQuery('#add-date-button').on('click',function(){
		jQuery('#right-date').css('display','none');
		jQuery('.datepicker').css('display','block');
		jQuery('#add-date').css('display','block');
		jQuery('.main-container .top_table_block table tr td').css('width','4.78%');
	});

	jQuery('#add-date').on('click',function(){
		
		if(selected_date == undefined) {
			jQuery('.datepicker').css({'border-color':'red'});
			jQuery('.datepicker').datepicker('show');
			return false;
		}
		jQuery('#info').hide();
		jQuery('#fade').show();
		jQuery('.datepicker').datepicker('hide');	

		jQuery('.datepicker').css({'border-color':'#f7f7f7'});
		current_data = {
			date : selected_date,
		}
		var datas = {
			action: 'date',
	        data: current_data,
	        type: 'add'
		};
		
		jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
			jQuery('#add-date').hide();
			jQuery('.datepicker').hide();
			jQuery('#right-date').show();
			jQuery('.main-container .top_table_block table tr td').css('width','3.75%');
			jQuery('#fade').hide();
			jQuery('#info').show();
			var inc = 0;
			jQuery('.dates').find('td').each(function(){
				if(jQuery(this).data('relation-id') == undefined && jQuery(this).index() != 0){
					inc = jQuery(this).index();
					return false;
				}
			});
			if (inc != 0) {
				inc = inc - 1;
			};

			jQuery('.main-container tr').each(function(){
				jQuery(this).children('td').eq(inc+1).remove();
				if(jQuery(this).attr('class') == 'dates') {
					jQuery(this).find('td:eq('+inc+')').after('<td data-relation-id='+response.id+'><input type="checkbox">'+selected_date+'</td>');
				} else {
					jQuery(this).find('td:eq('+inc+')').after("<td><div class='comment no-data'><div>-</div><div class='comment_icon'></div></div></td>");
				}

				jQuery( ".comment div:first-child" ).hover(function(event) {
					jQuery( this ).parent().addClass('hovered');
				},function(event) {
					jQuery( this ).parent().removeClass('hovered');
				});
			});
	 	}, 'json');
	 	return false;


	});

            
});

jQuery( document ).ready(function() {		
		var options = {
			//Boolean - If we show the scale above the chart data			
			scaleOverlay : false,			
			//Boolean - If we want to override with a hard coded scale
			scaleOverride : true,			
			//** Required if scaleOverride is true **
			//Number - The number of steps in a hard coded scale
			scaleSteps : 10,
			//Number - The value jump in the hard coded scale
			scaleStepWidth : 10,
			//Number - The scale starting value
			scaleStartValue : 0,
			//String - Colour of the scale line	
			scaleLineColor : "rgba(0,0,0,.1)",			
			//Number - Pixel width of the scale line	
			scaleLineWidth : 1,
			//Boolean - Whether to show labels on the scale	
			scaleShowLabels : true,			
			//Interpolated JS string - can access value
			scaleLabel : "<%=value%>",			
			//String - Scale label font declaration for the scale label
			scaleFontFamily : "'Arial'",			
			//Number - Scale label font size in pixels	
			scaleFontSize : 12,			
			//String - Scale label font weight style	
			scaleFontStyle : "normal",			
			//String - Scale label font colour	
			scaleFontColor : "#267893",				
			///Boolean - Whether grid lines are shown across the chart
			scaleShowGridLines : true,			
			//String - Colour of the grid lines
			scaleGridLineColor : "#e4ecf1",			
			//Number - Width of the grid lines
			scaleGridLineWidth : 1,				
			//Boolean - Whether the line is curved between points
			bezierCurve : true,			
			//Boolean - Whether to show a dot for each point
			pointDot : true,			
			//Number - Radius of each point dot in pixels
			pointDotRadius : 3,			
			//Number - Pixel width of point dot stroke
			pointDotStrokeWidth : 1,			
			//Boolean - Whether to show a stroke for datasets
			datasetStroke : true,			
			//Number - Pixel width of dataset stroke
			datasetStrokeWidth : 2,			
			//Boolean - Whether to fill the dataset with a colour
			datasetFill : true,			
			//Boolean - Whether to animate the chart
			animation : true,
			//Number - Number of animation steps
			animationSteps : 60,			
			//String - Animation easing effect
			animationEasing : "easeOutQuart",
			//Function - Fires when the animation is complete
			onAnimationComplete : null
			
		};
		var all_dates = [<?php echo '"'.implode('","', $patient_data->scheduler['dates']).'"' ?>];
		var rec_data = [<?php echo '"'.implode('","', $patient_data->scheduler['recovery']).'"' ?>];
		var data = {
			labels : all_dates,
			datasets : [
				{
					fillColor : "transparent",
					strokeColor : "#3d869e",
					pointColor : "transparent",
					pointStrokeColor : "transparent",
					data : rec_data,
				}				
			]
		};
		var ctx = document.getElementById("myChart").getContext("2d");
		var myNewChart = new Chart(ctx).Line(data,options);
	    var min = all_dates[0].split("-");
	    var max = all_dates[all_dates.length - 1].split("-");
	    
	    var bound_min = "<?php echo $patient_data->scheduler['min'];?>";
	    var bound_max = "<?php echo $patient_data->scheduler['max'];?>";

	    var min_array = bound_min.split("-");
	    var max_array = bound_max.split("-");

	    function daydiff(first, second) {
		    return (second-first)/(1000*60*60*24);
		}

		var day_diff = daydiff(new Date(min[0], min[1] - 1, min[2]), new Date(max[0], max[1] - 1, max[2]));
		var rec_diff = rec_data[rec_data.length - 1];
		jQuery('#infoDays').text('Days '+day_diff);
		jQuery('#infoProcents').text(rec_diff + '%');
		
	    //Slider
		jQuery("#slider").dateRangeSlider(
			{
				 bounds: {min: new Date(min_array[0], min_array[1] - 2, min_array[2]), max: new Date(max_array[0], max_array[1] , max_array[2])},
    			 defaultValues: {min: new Date(min[0], min[1] - 1, min[2]), max: new Date(max[0], max[1] - 1, max[2])},
    
	  		});
		
	    jQuery("#slider").bind("userValuesChanged", function(e, data) {
	    	var days = daydiff(data.values.min, data.values.max);
	    	
	    	jQuery('#infoDays').text('Days '+ Math.round(days));
	    	jQuery('#infoProcents').text((Math.floor(Math.random() * 100) + 1)+' %');
	    	var min_date = data.values.min;

	    	var year = min_date.getFullYear();
		  	var month = min_date.getMonth() + 1;
		  	var day = min_date.getDate();
		  	if(day < 10) {
		  		day = "0"+day;
		  	}
		  	if(month < 10) {
		  		month = "0"+month;
		  	}
		  	min_date = year+'-'+month+'-'+day;

	    	var max_date = data.values.max;
	    	var year = max_date.getFullYear();
		  	var month = max_date.getMonth() + 1;
		  	var day = max_date.getDate();
		  	if(day < 10) {
		  		day = "0"+day;
		  	}
		  	if(month < 10) {
		  		month = "0"+month;
		  	}
		  	max_date = year+'-'+month+'-'+day;
	    	jQuery('#info').hide();
	    	jQuery.confirm({
	    		text: "Are you sure you want to change date range?",
			    confirm: function(button) {			    	
			    	jQuery('#fade').show();
			        window.location.href = "<?php echo $current_url;?>"+"&start_date="+min_date+"&end_date="+max_date;
			    },
			    cancel: function(button) {
			        jQuery('#info').show();
			    }
			});
	    	

		});

	    //Calculate Graph sizes
	    var paddings = 22;
		var GraphWidth = jQuery('#myChart').width();
		var GraphHeight = jQuery('#myChart').height();
		var GraphPosition = jQuery('#myChart').offset();

		jQuery('#info').height(GraphHeight-paddings);
		jQuery('#info').css({'top': GraphPosition.top, 'left': GraphWidth/2});

		jQuery('#fade').hide();
		jQuery('#info').show();
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
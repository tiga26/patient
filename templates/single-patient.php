<?php
/*
 * Template Name: Patient Statistics
 */
require_once dirname(__FILE__).'/../class-db-manager.php';

$patient = new Patient_Db_Manager();

$patient_data = $patient->setPatient(1)
						->loadPatientAllData()
						->getPatientData();

// var_dump($patient_data);exit;
get_header();
?>
<div class="main-container">
	<div>
	 	<div class="top_table_block">
		 	<table class="recovery">
		 		<tr class="dates">
		 			<td id='dates'>Dates</td>
		 			<td><input type="checkbox">03.04.2006</td>
		 			<td><input type="checkbox">15.04.2006</td>
		 			<td><input type="checkbox">21.04.2006</td>
		 			<td><input type="checkbox">04.05.2006</td>
		 			<td><input type="checkbox">30.05.2006</td>
		 			<td><input type="checkbox">31.05.2006</td>
		 		</tr>
		 		<tr class="rec_status">
		 			<td>Recovery Status</td>
		 			<td>10%</td>
		 			<td>20%</td>
		 			<td>
		 			<div class="comment" title="<div class='comment_block'><div>User Coment</div><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.</div>">
		 			<select id='rec_select' size="4">
			 			<option>0%</option>
			 			<option>10%</option>
			 			<option>20%</option>
			 			<option>30%</option>
			 			<option>40%</option>
			 			<option>50%</option>
			 			<option>60%</option>
			 			<option>70%</option>
			 			<option>80%</option>
		 			</select></div>
		 			</td>
		 			<td>40%</td>
		 			<td>50%</td>
		 			<td>-</td>
		 		</tr>
		 	</table>
		</div>
	 	<div id="accordion">
	 		<div class="header-line">
	 			<div class="first-child">Symptoms</div><div class="btn my">my symptoms</div><div class="btn">all symptoms</div>
	 		</div>
	 		<div>
	 			<div id="accordion1">
	 				<div>Mental Symptoms</div>
	 				<table>
	 					<tr>
	 						<td><input type="checkbox"><label>Symptom A</label></td>
	 						<td>3</td>
	 						<td class="none">None</td>
	 						<td>4</td>
	 						<td>3</td>
	 						<td>3</td>
	 						<td>-</td>
	 					</tr>
	 					<tr>
	 						<td><input type="checkbox"><label>Symptom B</label></td>
	 						<td>2</td>
	 						<td>3</td>
	 						<td>3</td>
	 						<td>2</td>
	 						<td>3</td>
	 						<td>-</td>
	 					</tr>
	 					<tr>
	 						<td><input type="checkbox">Symptom C</td>
	 						<td>1</td>
	 						<td>3</td>
	 						<td>2</td>
	 						<td>2</td>
	 						<td>2</td>
	 						<td>-</td>
	 					</tr>
	 				</table>
	 				<div>Sexual Symptoms</div>
	 				<table>
	 					<tr>
	 						<td><input type="checkbox">Symptom D</td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td>-</td>
	 					</tr>
	 					<tr>
	 						<td><input type="checkbox">Symptom E</td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td>-</td>
	 					</tr>
	 					<tr>
	 						<td><input type="checkbox">Symptom F</td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td></td>
	 						<td>-</td>
	 					</tr>
	 				</table>
	 				<div>Physical Symptoms</div>
	 				<table>
	 					<tr>
	 						<td><input type="checkbox">Symptom G</td>
	 						<td>1</td>
	 						<td>2</td>
	 						<td>3</td>
	 						<td class="none">None</td>
	 						<td class="none">None</td>
	 						<td>-</td>
	 					</tr>
	 					<tr>
	 						<td><label><input type="checkbox">Symptom H</label></td>
	 						<td>0</td>
	 						<td>1</td>
	 						<td>2</td>
	 						<td>3</td>
	 						<td class="none">None</td>
	 						<td>-</td>
	 					</tr>
	 					<tr>
	 						<td><label><input type="checkbox">Symptom I<label></td>
	 						<td>1</td>
	 						<td>4</td>
	 						<td>3</td>
	 						<td class="none">None</td>
	 						<td class="none">None</td>
	 						<td>-</td>
	 					</tr>
	 				</table>
	 			</div>
			</div>
	 		<div class="header-line">
	 			<div class="first-child">Assays</div><div class="btn my">my assays</div><div class="btn">all assays</div>
	 		</div>
			<div>
				<table class="assays">
					<tr>
						<td><input type="checkbox">DHT</td>
						<td>15%</td>
						<td>10%</td>
						<td><div class="comment"><div>05%</div><div class="comment_icon" title="<div class='comment_block'><div>Result<span>*</span>:</div><div class='value'>15mg</div><div>Reference<span>*</span>:</div><div class='value'>10mg - 20mg = 50%</div><div>User Coment</div><br><br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.</div>"></div></div></td>
						<td>20%</td>
						<td>20%</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Testosterone</td>
						<td>15%</td>
						<td>10%</td>
						<td>05%</td>
						<td>20%</td>
						<td>20%</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">3a-diol-G</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td>20%</td>
						<td>20%</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Example 01</td>
						<td class="none">None</td>
						<td>10%</td>
						<td>05%</td>
						<td>20%</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Example 02</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td>05%</td>
						<td class="none">None</td>
						<td>-</td>
					</tr>
				</table>
			</div>
			<div class="header-line">
				<div class="first-child">Diagnoses</div><div class="btn my">my diagnoses</div><div class="btn">all diagnoses</div>
			</div>
			<div>
				<table class="diagnoses">
					<tr>
						<td><input type="checkbox">Osteoporosis</td>
						<td><div class="comment"><div>Dr.Si..</div><div class="comment_icon" title="<div class='comment_block'><div>Doctor</div><div class='value'>Dr. Mindes,USA</div><div>Comment</div><br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.</div>"></div></div></td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Tertiary Hipogonadian</td>
						<td>Dr.Si..</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td>-</td>
					</tr>
				</table>
			</div>
			<div class="header-line">
				<div class="first-child">Therapies</div><div class="btn my">my therapies</div><div class="btn">all therapies</div>
			</div>
			<div>
				<table class="therapies">
					<tr>
						<td><input type="checkbox">TRT</td>
						<td>20ml/2</td>
						<td class="none">None</td>
						<td class="none">None</td> 
						<td class="none">None</td>
						<td>20ml/2</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Arimide</td>
						<td><div class="comment"><div>20ml/2</div><div class="comment_icon" title="<div class='comment_block'><div>Dosage:</div><div class='value'>15ml every 1 day</div><div>Doctor:</div><div class='value'>Dr. Mindesaa,USA</div><div>Effect:</div><br><div class='block_header'><div id='left_column_header'>Symptom</div><div id='right_column_header'>Effect</div><br></div><div><div class='effect_main_block'><div class='row'>Symptom1<div class='value'>1</div></div><div class='row'>Symptom1<div class='value'>1</div></div></div></div><div class='bottom-block'>User Coment</div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue."></div></div></div></td>
						<td class="none">None</td>
						<td>20ml/2</td>
						<td>20ml/2</td>
						<td class="none">None</td>
						<td>-</td>
					</tr>
					<tr>
						<td><input type="checkbox">Zinc Suppliments</td>
						<td>20ml/2</td>
						<td class="none">None</td>
						<td>20ml/2</td>
						<td>20ml/2</td>
						<td class="none">None</td>
						<td>-</td>
					</tr>
				</table>
			</div>
			<div class="header-line">
				<div class="first-child">Lyfestyle</div><div class="btn my">my lifestyle type</div><div class="btn all">all lifestyle types</div>
			</div>
			<div>
				<table class="lifestyle">
					<tr>
						<td><input type="checkbox">Daily Physical Training<br></td>
						<td>1/Day</td>
						<td>1/Day</td>
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
					</tr>
					<!-- <tr class="add-row">
						<td><input type="text">
							<div class="add"></div>
						</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td class="none">None</td>
						<td>-</td>
					</tr> -->
				</table>
			</div>
		</div>
		<div class="clear"></div>
		<!-- <div class="dialog recovery">Your Comment:
			<textarea name='comment'></textarea>
			<div class="btn">
				<a class="delete"></a>
				<a class="save"></a>
			</div>
		</div> -->
		<div class="dialog assays">Result<span>*</span>:
			<input type="text" id="first-child">
			<select>
				<option>mg</option>
				<option>kg</option>
				<option>kg</option>
				<option>kg</option>
				<option>kg</option>
				<option>kg</option>
				<option>kg</option>
				<option>kg</option>
			</select>
			<input type='text' class="add_item">
			<div class="add"></div><br>
			Reference<span>*</span>:
			<input type="text"> - <input type="text"> = <input type="text"> <br>
			<textarea name='comment'></textarea>
			<span>* Please fill out all required fields</span>
			<div class="clear"></div>
			<div class="btn">
				<a class="delete"></a>
				<a class="cancel"></a>
				<a class="save"></a>
			</div>
		</div>
		<div class="dialog symptom">
			<div>Defintion</div>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.
			<div>Find related:</div>
			<a href="" class="message"></a>
			<a href="" class="friends"></a>
			<a href="" class="prof"></a>
			<a href="" class="search"></a>
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
					<option>Doctor</option>
					<option>Donals</option>
					<option>Burns</option>
					<option>Michael</option>
					<option>Michael</option>
					<option>Michael</option>
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
			<div>every <input type="text">  day</div><br>
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
			<label><input type='checkbox'>Selft Prescribed</label><br>
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
	<!-- <div class="pop-up" id="error_data_entry">
		<div class="pop-up-inner-block">
			<p>Data Entry <b>Error</b></p>
			<p>[ESC]</p><br><hr>
			<span>Pleas enter range from <b>0-100%</b></span>
		</div>
	</div> -->
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

	jQuery('select').selectbox({
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

	jQuery( ".dialog.assays .add" ).click(function() {
		jQuery('.dialog.assays .selectBox-dropdown').css('display','none');
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
		type = dialog_id;
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

	jQuery('.btn').click(function(event){
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

	Save = {

		saveRecovery: function() {
			
		},

		saveSymptoms: function() {
			
		},

		saveAssays: function() {
			var dialog = $('.dialog.assays');

			var current_data = {
				
				assay_id: 1,
				relation_id: 1,
				unit_id: 2,
				result: 20,
				ref_low: 7,
				ref_hi: 10,
				remarks: 'fsdfsdfsdfsdf'
				
			};
		},

		saveDiagnoses: function() {
			
		},

		saveTherapies: function() {
			
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

</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
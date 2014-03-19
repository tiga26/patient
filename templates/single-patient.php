<?php
/*
 * Template Name: Patient Statistics
 */
require_once dirname(__FILE__).'/../class-db-manager.php';

$patient = new Patient_Db_Manager();

$patient_data = $patient->setPatient(1)
						->loadPatientAllData()
						->getPatientData();

var_dump($patient_data);exit;
get_header();
?>
<div class="main-container">
 <div>
 	<div class="top_table_block">
	 	<table>
	 		<tr class="dates">
	 			<td id='dates'>Dates</td>
	 			<td><input type="checkbox">03.04.2006</td>
	 			<td><input type="checkbox">15.04.2006</td>
	 			<td><input type="checkbox">21.04.2006</td>
	 			<td><input type="checkbox">04.05.2006</td>
	 			<td><input type="checkbox">30.05.2006</td>
	 			<td><input type="text"><div class="add"></div></td>
	 		</tr>
	 		<tr class="rec_status">
	 			<td>Recovery Status</td>
	 			<td>10%</td>
	 			<td>20%</td>
	 			<td><select id='rec_select'>
		 			<option>0%</option>
		 			<option>10%</option>
		 			<option>20%</option>
		 			<option>30%</option>
		 			<option>40%</option>
		 			<option>50%</option>
		 			<option>60%</option>
		 			<option>70%</option>
		 			<option>80%</option>
	 			</select>
	 			<div class="comment" title="<div class='comment_block'><div>User Coment</div><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.</div>"></div>
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
 						<td><input type="checkbox">Symptom A</td>
 						<td>3</td>
 						<td class="none">None</td>
 						<td>4</td>
 						<td>3</td>
 						<td>3</td>
 						<td>-</td>
 					</tr>
 					<tr>
 						<td><input type="checkbox">Symptom B</td>
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
 						<td><input type="checkbox">Symptom H</td>
 						<td>0</td>
 						<td>1</td>
 						<td>2</td>
 						<td>3</td>
 						<td class="none">None</td>
 						<td>-</td>
 					</tr>
 					<tr>
 						<td><input type="checkbox">Symptom I</td>
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
					<td>05%<div class="comment" title="<div class='comment_block'><div>Result<span>*</span>:</div><div class='value'>15mg</div><div>Reference<span>*</span>:</div><div class='value'>10mg - 20mg = 50%</div><div>User Coment</div><br><br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.</div>"></div></td>
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
					<td>Dr.Si..<div class="comment" title="<div class='comment_block'><div>Doctor</div><div class='value'>Dr. Mindes,USA</div><div>Comment</div><br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis augue erat, sit amet vulputate quam pretium nec. Suspendisse nec mauris a justo lobortis congue.</div>"></div></td>
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
			<table>
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
					<td>20ml/2</td>
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
				<tr class="add-row">
					<td><input type="text">
						<div class="add"></div>
					</td>
					<td class="none">None</td>
					<td class="none">None</td>
					<td class="none">None</td>
					<td class="none">None</td>
					<td class="none">None</td>
					<td>-</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="clear"></div>
	<div class="dialog recovery">Your Comment:
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
	<div class="dialog diagnoses">Doctor:
		<div class="clear-both"></div>
		<input type="text" id="country">
		<input type="text" id="doctor">
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
		<input type="text"><div class="add_doctor"></div>
		Your Comment:
		<textarea name='comment'></textarea>
		<div class="btn">
			<a class="delete"></a>
			<a class="save"></a>
		</div>
	</div>
<script>
	jQuery( "#accordion,#accordion1" ).accordion({ 
		active: 'false', 
		collapsible: true,
		heightStyle: "content",
		beforeActivate: function(event, ui) {
	         // The accordion believes a panel is being opened
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

	jQuery('select').selectBox({
		customScrollbar: true,
	});

	jQuery('#rec_select').selectBox({
		customScrollbar: true,
		width: 75,
	});

	jQuery('#doctor_select').selectBox({
		customScrollbar: true,
		width: 300,
	});

	jQuery('#country_select').selectBox({
		customScrollbar: true,
		width: 200,
	});

	jQuery('.rec_status .selectBox-dropdown').hover(function(){
		jQuery('.rec_status .selectBox-arrow').css('display','block');
    	jQuery('.selectBox-dropdown').css('border','1px solid #eaeaea');
    },function(){
		jQuery('.rec_status .selectBox-arrow').css('display','none');
    	jQuery('.selectBox-dropdown').css('border','none');
    });

    jQuery(function(){
		jQuery('.selectBox-dropdown-menu').jScrollPane({
			showArrows: false,
			autoReinitialise: true
		});
	});

	jQuery( ".dialog" ).dialog({ 
		autoOpen: false,
		position: { 
			my: "left bottom",
		    at: "left-100 top",
		    of: ".comment"
		}
	});

	jQuery( ".rec_status .comment" ).click(function() {
		if(jQuery( ".dialog.recovery" ).dialog( "isOpen" )){
			jQuery('.rec_status .comment').removeClass('add');
			jQuery( ".dialog.recovery" ).dialog( "close" );
			jQuery( document).tooltip({ disabled: false });
		}else{
			jQuery('.rec_status .comment').addClass('add');
			jQuery( ".dialog.recovery" ).dialog( "open" );
			jQuery( document).tooltip({ disabled: true });   
		}
	});

	jQuery( ".assays .comment" ).click(function() {
		if(jQuery( ".dialog.assays" ).dialog( "isOpen" )){
			jQuery('.assays .comment').removeClass('add');
			jQuery( ".dialog.assays" ).dialog( "close" );
			jQuery( document).tooltip({ disabled: false });
		}else{
			jQuery('.assays .comment').addClass('add');
			jQuery( ".dialog.assays" ).dialog( "open" );
			jQuery( document).tooltip({ disabled: true });   
		}
	});

	jQuery( ".dialog.assays .add" ).click(function() {
		jQuery('.dialog.assays .selectBox-dropdown').css('display','none');
		jQuery('.add_item').css('display','inline-block');
		jQuery('.add').css('background-position','0px -31px');
	});

	jQuery( ".diagnoses .comment" ).click(function() {
		if(jQuery( ".dialog.diagnoses" ).dialog( "isOpen" )){
			jQuery('.diagnoses .comment').removeClass('add');
			jQuery( ".dialog.diagnoses" ).dialog( "close" );
			jQuery( document).tooltip({ disabled: false });
		}else{
			jQuery('.diagnoses .comment').addClass('add');
			jQuery( ".dialog.diagnoses" ).dialog( "open" );
			jQuery( document).tooltip({ disabled: true });   
		}
	});

	jQuery(document).ready(function(){
		jQuery.widget("ui.tooltip", jQuery.ui.tooltip, {
	        options: {
	            content: function () {
	             return jQuery(this).prop('title');
	           }
	             }
	         });
		jQuery( document).tooltip({
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
	});
</script>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
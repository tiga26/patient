jQuery(document).ready(function(){
	jQuery('#edit').live('click',function(){
	
		var datas = '3';
		jQuery.post(admin_ajax_script.ajaxurl, datas, function(response) {
			
	 	}, 'json');	
	});;	
});



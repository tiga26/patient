var ajaxurl = "<?php echo plugins_url().'admin-ajax.php'; ?>";
jQuery('#edit').live('click',function(){
	
	var datas = '3';
	jQuery.post(ajaxurl, datas, function(response) {
		
 	}, 'json');	
});;


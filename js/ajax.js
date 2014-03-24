// jQuery(".rec_status").on('click', function() {
// 	var data = {
// 		action: 'test_response',
//         post_var: 'this will be echoed back'
// 	};
// 	// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
//  	jQuery.post(the_ajax_script.ajaxurl, data, function(response) {
// 		alert(response);
//  	});
//  	return false;
// });

jQuery(".rec_status").on('click', function() {

	var data = {
		action: 'symptom',
        data: 'symptom',
        type: 'get'
	};
	// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
 	jQuery.post(the_ajax_script.ajaxurl, data, function(response) {
		alert(response);
 	});
 	return false;
});
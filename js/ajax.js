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
		id: 1,
	};
	var datas = {
		action: 'assay',
        data: data,
        type: 'get'
	};
	// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
 	jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
		alert(response);
 	});
 	return false;
});

// jQuery("#dates").on('click', function() {
// 	var data = {
// 		rrlation_id: 1,
// 		value: 20,
// 		symptom_id: 2
// 	};
// 	var datas = {
// 		action: 'symptom',
//         data: data,
//         type: 'set'
// 	};
// 	// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
//  	jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
// 		alert(response);
//  	});
//  	return false;
// });

jQuery("#dates").on('click', function() {
	var data = {
		assay_id: 1,
		relation_id: 1,
		unit_id: 2,
		result: 20,
		ref_low: 7,
		ref_hi: 10,
		remarks: 'fsdfsdfsdfsdf'
	};
	var datas = {
		action: 'assay',
        data: data,
        type: 'set'
	};
	// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
 	jQuery.post(the_ajax_script.ajaxurl, datas, function(response) {
		alert(response);
 	});
 	return false;
});
define(function(require) {
	var $ = require('jquery');

	// profile details accordion    
	$('#custom_fields_userdetails.profile-manager-accordion').accordion({
		header: 'h3',
		heightStyle: 'content',
		icons: {
	    	header: 'elgg-icon fa fa-caret-right float-alt',
    		activeHeader: 'elgg-icon fa fa-caret-down float-alt'
		}
	});
});

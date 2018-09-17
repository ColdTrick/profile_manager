define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var tabs = require('page/components/tabs');

	/**
	 * show description and fields based on selected profile type (profile edit)
	 */
	function change_profile_type() {
		var selVal = $('#custom_profile_type').val();

		$('.custom_fields_edit_profile_category, .custom_profile_type_description').hide();

		$('.custom_profile_type_0').show();
		if (selVal !== '') {
			$('.custom_profile_type_' + selVal).show();
			$('#custom_profile_type_description_'+ selVal).show();
		}

		if ($('.custom_fields_edit_profile_category.elgg-state-selected:visible').length === 0) {
			$('.custom_fields_edit_profile_category:visible:first a').click();
		}
	};
	
	$(document).on('change', '#custom_profile_type', change_profile_type);
	change_profile_type();
});

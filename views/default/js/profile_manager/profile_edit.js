elgg.provide('elgg.profile_manager');

//show description and fields based on selected profile type (profile edit)
elgg.profile_manager.change_profile_type = function(){
	var selVal = $('#custom_profile_type').val();
	
	$('.custom_fields_edit_profile_category').hide();
	$('.custom_profile_type_description').hide();

	if (selVal !== '') {
		$('.custom_profile_type_' + selVal).show();
		$('#custom_profile_type_description_'+ selVal).show();
	}
	
	if ($('#profile_manager_profile_edit_tabs li.elgg-state-selected:visible').length === 0) {
		$('#profile_manager_profile_edit_tabs a:first:visible').click();
	}
};

elgg.profile_manager.init_edit = function() {
	elgg.profile_manager.change_profile_type();
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.profile_manager.init_edit);

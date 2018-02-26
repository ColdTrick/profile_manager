elgg.provide('elgg.profile_manager');

//show description and fields based on selected profile type (register form)
elgg.profile_manager.change_profile_type_register = function() {
	var selVal = $('#custom_profile_fields_custom_profile_type').val();
	if(selVal === '' || selVal === 'undefined'){
		selVal = 0;
	}

	// profile type description
	$('div.custom_profile_type_description').hide();
	$('#'+ selVal).show();

	var $tabs = $('.register-form-fields .elgg-tabs');
	if ($tabs.length > 0) {
		$tabs.find('li').hide();
		$tabs.find(".profile_type_0, .profile_type_" + selVal).show();
		if ($tabs.find('li.elgg-state-selected:visible').length === 0) {
			$tabs.find('li:visible:first>a').click();
		} else {
			$tabs.find('li.elgg-state-selected:visible').click();
		}
	} else {
		// list
		$('.profile_manager_register_category').hide();
		$('.profile_manager_register_category.profile_type_0, .profile_manager_register_category.profile_type_' + selVal).show();
	}
};

elgg.profile_manager.init_register = function() {	
	// add username generation when a email adress has been entered
	$(document).on('blur', '.elgg-form-register input[name="email"]', function(){
		var email_value = $(this).val();
		
		if (email_value.indexOf('@') !== -1) {
			var pre = email_value.split('@');
			if (pre[0]) {
				if ($('.elgg-form-register input[name="username"]').val() === '') {
					// change value and trigger change
					var new_val = pre[0].replace(/[^a-zA-Z0-9]/g, '');
					$('.elgg-form-register input[name="username"]').val(new_val).keyup();
				}
			}
		}
	});
	
	elgg.profile_manager.change_profile_type_register();
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.profile_manager.init_register);

elgg.provide('elgg.profile_manager');

var profile_manager_register_form_timers = [];
var profile_manager_register_form_validate_xhr = [];

//live input validation
elgg.profile_manager.register_form_validate = function(form, field) {
	var $field = $(field);
	var fieldname = $field.attr('name');
	var fieldvalue = $field.val();
	var $field_icon = $field.next('.profile_manager_validate_icon');
	
	if (profile_manager_register_form_validate_xhr[fieldname]) {
		// cancel running ajax calls
		profile_manager_register_form_validate_xhr[fieldname].abort();
	}
	
	$field_icon.addClass('hidden fa-pulse fa-spinner').attr('title', '');

	if (fieldvalue === '') {
		return;
	}
	
	var data = {};
	data.name = fieldname;
	data[fieldname] = fieldvalue;

	$field_icon.removeClass('hidden');
	
	profile_manager_register_form_validate_xhr[fieldname] = elgg.action('profile_manager/register/validate', {
		data: data,
		success: function(data) {
			// process results
			if (data.output) {
				$field_icon.removeClass('fa-pulse fa-spinner fa-exclamation-circle fa-check-circle');
				
				if (data.output.status === false) {
					// something went wrong; show error icon and add title
					$field_icon.addClass('fa-exclamation-circle');
				}

				if (data.output.status === true) {
					// something went right; show success icon
					$field_icon.addClass('fa-check-circle');
					$field.removeClass('profile_manager_register_missing');
				}
				
				if (data.output.text) {
					$field_icon.attr('title', data.output.text);
				}
			}
		},
		error: function() {
			// custom error to prevent default elgg ajax abortion notice
		}
	});
};

//show description and fields based on selected profile type (register form)
elgg.profile_manager.change_profile_type_register = function() {
	var selVal = $('#custom_profile_fields_custom_profile_type').val();
	if(selVal === '' || selVal === 'undefined'){
		selVal = 0;
	}

	// profile type description
	$('div.custom_profile_type_description').hide();
	$('#'+ selVal).show();

	// tabs
	var $tabs = $('#profile_manager_register_tabbed');
	if ($tabs.length > 0) {
		$tabs.find('li').hide();
		$tabs.find(".profile_type_0, .profile_type_" + selVal).show();
		if ($tabs.find('li.selected:visible').length === 0) {
			$tabs.find('li:visible:first>a').click();
		} else {
			$tabs.find('li.selected:visible').click();
		}
	} else {
		// list
		$('.profile_manager_register_category').hide();
		$('.profile_manager_register_category.profile_type_0, .profile_manager_register_category.profile_type_' + selVal).show();
	}
};

//tab switcher on register form
elgg.profile_manager.toggle_tabbed_nav = function(div_id, element) {
	var $content_container = $('#profile_manager_register_tabbed').next();
	$content_container.find('>div').hide();
	$content_container.find('>div.category_' + div_id).show();

	$('#profile_manager_register_tabbed li.elgg-state-selected').removeClass('elgg-state-selected');
	$(element).parent('li').addClass("elgg-state-selected");
};

elgg.profile_manager.init_register = function() {
	
	// validate on submit
	$(document).on('submit', '.elgg-form-register', function() {
		var error_count = 0;
		var result = false;

		var $form = $(this);
		var selProfileType = $('#custom_profile_fields_custom_profile_type').val();
		if (selProfileType === '') {
			selProfileType = 0;
		}
		
		$form.find('.mandatory').find('input, select, textarea').each(function(index, elem) {
			
			switch($(elem).attr('type')){
				case 'radio':
				case 'checkbox':
					$(elem).parent('.mandatory').removeClass('profile_manager_register_missing');

					// check parents
					var $parents = $(elem).parents('.profile_manager_register_category');
					if (($parents.length === 0) || ($parents.hasClass('category_' + selProfileType) || $parents.hasClass('category_0'))) {
						if ($form.find('input[name="' + $(elem).attr('name') + '"]:checked').length === 0) {
							
							$(elem).parent('.mandatory').addClass('profile_manager_register_missing');
							error_count++;
						}
					}
					break;
				default:
					$(elem).removeClass('profile_manager_register_missing');
					// also remove class from multiselect element
					$(elem).next('.ui-multiselect').removeClass('profile_manager_register_missing');

					// check parents
					var $parents = $(elem).parents('.profile_manager_register_category');
					if (($parents.length === 0) || ($parents.hasClass('profile_type_' + selProfileType) || $parents.hasClass('profile_type_0'))) {
					
						if ($(elem).is('select')) {
							if (($(elem).val() === null) || ($(elem).val() === '')) {
								$(elem).addClass('profile_manager_register_missing');
								// also add class to multiselect element
								$(elem).next('.ui-multiselect').addClass('profile_manager_register_missing');
								
								error_count++;
							}
						} else {
							
							if ($(elem).val().trim() === '') {
								$(elem).addClass('profile_manager_register_missing');
								error_count++;
							}
						}
					}
					break;
			}
		});
	
		if (error_count > 0) {
			alert(elgg.echo('profile_manager:register:mandatory'));
		} else {
			result = true;
		}
	
		return result;
	});
	
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

	// add live validation of username and emailaddress
	$(document).on('keyup', '.elgg-form-register input[name="username"], .elgg-form-register input[name="email"], .elgg-form-register input[name="password"]', function(event){
		var fieldname = $(event.currentTarget).attr('name');
		var form = $(this).parents('.elgg-form-register');
		
		clearTimeout(profile_manager_register_form_timers[fieldname]);
		profile_manager_register_form_timers[fieldname] = setTimeout(function() {
			elgg.profile_manager.register_form_validate(form, $(event.currentTarget));
		}, 500);
	});

	// password compare check
	$(document).on('keyup', '.elgg-form-register input[name="password"], .elgg-form-register input[name="password2"]', function() {
		var $form = $(this).parents('.elgg-form-register');
		
		var password1 = $form.find('input[name="password"]').val();
		var password2 = $form.find('input[name="password2"]').val();
		
		var $field = $form.find('input[name="password2"]');
		var $field_icon = $field.next('.profile_manager_validate_icon');
		
		$field_icon.addClass('hidden').removeClass('fa-pulse fa-spinner fa-exclamation-circle fa-check-circle').attr('title', '');
		if ((password1 !== '') && (password2 !== '')) {
			$field_icon.removeClass('hidden');
			if (password1 == password2) {
				$field_icon.addClass('fa-check-circle');
				$field.removeClass('profile_manager_register_missing');
			} else {
				$field_icon.addClass('fa-exclamation-circle').attr('title', elgg.echo('RegistrationException:PasswordMismatch'));
			}
		}
	});
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.profile_manager.init_register);
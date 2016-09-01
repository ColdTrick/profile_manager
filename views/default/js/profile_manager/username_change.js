define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	
	var profile_manager_username_validate_xhr;

	var validate = function(event, elem) {
		if (event.which == 13) {
			return;
		}
			
		var $field = $(elem);
		var $field_icon = $field.next('.profile_manager_validate_icon');
		
		var fieldvalue = $field.val();

		if (profile_manager_username_validate_xhr) {
			// cancel running ajax calls
			profile_manager_username_validate_xhr.abort();
		}
		
		$field_icon.addClass('hidden fa-pulse fa-spinner').attr('title', '');

		if (fieldvalue == $field.attr('rel')) {
			return;
		}
			
		var data = {};
		data.name = 'username';
		data.username = fieldvalue;
		
		$field_icon.removeClass('hidden');
		
		profile_manager_username_validate_xhr = elgg.action('profile_manager/register/validate', {
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
	
	// username change
	$(document).on('keyup', '#profile_manager_username .elgg-input-text', function(event) {
		validate(event, $(this));
	});
});

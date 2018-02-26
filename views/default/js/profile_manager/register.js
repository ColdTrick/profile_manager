define(function(require) {
	var $ = require('jquery');

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
});

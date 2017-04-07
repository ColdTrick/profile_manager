define(function(require) {

	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');
	var ajax = new Ajax();

	$(document).on('change', '.profile-manager-profile-type-picker', function(e) {
		var $elem = $(this);
		ajax.view('profile/edit/fields', {
			data: {
				profile_type: $elem.val(),
				guid: $elem.data('guid')
			}
		}).done(function(output) {
			$elem.closest('form').find('.profile-manager-edit-profile-fields').html(output);
		});
	});
});
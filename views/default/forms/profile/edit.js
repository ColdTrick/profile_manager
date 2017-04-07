define(function (require) {

	var $ = require('jquery');

	$(document).on('change', '.profile-manager-simple-access-control .elgg-input-access', function () {
		var val = $(this).val();
		$(this).closest('form').find('.profile-manager-access-field input').val(val);
	});
});
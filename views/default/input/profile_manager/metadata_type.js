define(function(require) {

	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');
	var ajax = new Ajax();
	var lightbox = require('elgg/lightbox');

	$(document).on('change', '.profile-manager-metadata-type-picker', function(e) {
		var $elem = $(this);
		ajax.view('forms/profile_manager/field_options', {
			data: {
				metadata_type: $elem.val(),
				field_type: $elem.data('fieldType'),
				guid: $elem.data('guid')
			}
		}).done(function(output) {
			$elem.closest('form').find('.profile-manager-field-options').html(output);
			lightbox.resize();
		});
	});
});
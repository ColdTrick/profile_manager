define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	$(document).ready(function() {
		$('.profile-manager-multiselect').multiselect({
			header: false,
			selectedList: 4,
			noneSelectedText: elgg.echo('profile_manager:input:multi_select:empty_text')
		});
	});
});
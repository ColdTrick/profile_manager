define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
	var multiselect = require('jquery/multiselect');
	
	function MultiSelect() {};
	
	MultiSelect.prototype = {};
	
	MultiSelect.init = function(selector) {
		
		elgg.register_hook_handler("init", "system", function () {
			$(selector).each(function () {
				// we only want to wrap once
				if (!$(this).data("multiSelectInitialized")) {
					$(this)
						.multiselect({
							header: false,
							appendTo: "body",
							selectedList: 1,
							noneSelectedText: elgg.echo('profile_manager:input:multi_select:empty_text'),
							selectedText: elgg.echo('profile_manager:input:multi_select:selected_text')
						})
						.multiselect('getButton')
							.find('.ui-icon')
							.addClass('elgg-icon elgg-icon-caret-down fa fa-caret-down');
					$(this).data("multiSelectInitialized", 1);
				}
			});
		});
	};
	
	return MultiSelect;
});
import 'jquery';
import 'jquery-ui';
import 'jquery/multiselect';
import i18n from 'elgg/i18n';

export default {
	init: function(selector) {
		$(selector).each(function () {
			// we only want to wrap once
			if (!$(this).data('multiSelectInitialized')) {
				$(this)
					.multiselect({
						header: false,
						appendTo: 'body',
						selectedList: 1,
						noneSelectedText: i18n.echo('profile_manager:input:multi_select:empty_text'),
						selectedText: i18n.echo('profile_manager:input:multi_select:selected_text')
					})
					.multiselect('getButton')
						.find('.ui-icon')
						.addClass('elgg-icon elgg-icon-caret-down fa fa-caret-down');
				$(this).data('multiSelectInitialized', 1);
			}
		});
	}
}

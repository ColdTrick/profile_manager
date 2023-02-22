define(['jquery', 'elgg/i18n', 'elgg/Ajax', 'jquery-ui/widgets/sortable', 'jquery-ui/widgets/droppable'], function($, i18n, Ajax) {

	var ajax = new Ajax();

	function reorder_custom_fields() {
		ajax.action('profile_manager/reorder?' + $('#custom_fields_ordering').sortable('serialize'));
	};

	function filter_custom_fields(category_guid) {
		$('#custom_fields_ordering .elgg-item').hide();
		$('#custom_fields_category_list_custom .custom_fields_category_selected').removeClass('custom_fields_category_selected');
		if (category_guid === 0) {
			// show default
			$('#custom_fields_ordering .custom_field[rel=""]').parent().show();
			$('#custom_profile_field_category_0').addClass('custom_fields_category_selected');
		} else {
			if (category_guid === undefined) {
				// show all
				$('#custom_fields_ordering .custom_field').parent().show();
				$('#custom_profile_field_category_all').addClass('custom_fields_category_selected');
			} else {
				//show selected category
				$('#custom_fields_ordering .custom_field[rel="' + category_guid + '"]').parent().show();
				$('#custom_profile_field_category_' + category_guid).parent().addClass('custom_fields_category_selected');
			}
		}
	};

	function change_field_category(field, category_guid) {
		var field_guid = $(field).attr('id').replace('elgg-object-','');
		category_guid = category_guid.replace('elgg-object-','').replace('custom_profile_field_category_', '');
		
		ajax.action('profile_manager/change_category', {
			data: {
				guid: field_guid,
				category_guid: category_guid
			},
			success: function(data) {
				if (category_guid === '0') {
					category_guid = '';
				}

				$(field).find('.custom_field').attr('rel', category_guid);

				var current_cat_guid;
				var $selected_id = $('.custom_fields_category_selected').attr('id');
				if ($selected_id !== 'custom_profile_field_category_all') {
					current_cat_guid = 0;
					if ($selected_id !== 'custom_profile_field_category_0') {
						current_cat_guid = $selected_id.replace('elgg-object-','');
					}
				}
				
				filter_custom_fields(current_cat_guid);
			},
		});
	};
	
	filter_custom_fields(0);
	
	$(document).on('change', '#custom_fields_form select[name="metadata_type"]', function() {
		var $form = $('#custom_fields_form');
		$form.find('.custom_fields_form_field_option').prop('disabled', true);
		$form.find('.field_option_enable_' + $(this).val()).prop('disabled', false);
	});
	
	$('#custom_fields_ordering').sortable({
		update: function() {
			reorder_custom_fields();
		},
		opacity: 0.6,
		tolerance: 'pointer',
		items: 'li'
	});

	$('#custom_fields_category_list_custom .elgg-list').sortable({
		update: function() {
			ajax.action('profile_manager/categories/reorder?' + $('#custom_fields_category_list_custom .elgg-list').sortable('serialize'));
		},
		opacity: 0.6,
		tolerance: 'pointer',
		items: 'li',
		handle: '.elgg-icon-arrows-alt'
	});

	$('#custom_profile_field_category_0, #custom_fields_category_list_custom .elgg-item').droppable({
		accept: '#custom_fields_ordering .elgg-item',
		hoverClass: 'droppable-hover',
		tolerance: 'pointer',
		drop: function(event, ui) {
			change_field_category($(ui.draggable), $(this).attr('id'));
		}
	});
	
	$(document).on('click', '#custom_fields_category_list_custom .category-filter', function() {
		filter_custom_fields($(this).data().guid);
	});
	
	$(document).on('click', '.field_config_metadata_option_disabled, .field_config_metadata_option_enabled', function(event) {
		event.preventDefault();
		
		var $button = $(this);
	
		ajax.action('profile_manager/toggle_option', {
			data: {
				guid: $button.data().guid,
				field: $button.data().field
			},
			success: function(data) {
				$button.toggleClass('field_config_metadata_option_disabled field_config_metadata_option_enabled');
			},
		});
	});
	
	$(document).on('click', '.profile-manager-remove-field', function() {
		if (confirm(i18n.echo('profile_manager:actions:delete:confirm'))) {
			var guid = $(this).data().guid;
			
			ajax.action('entity/delete', {
				data: {
					guid: guid
				},
				success: function(data) {
				
					$('#custom_profile_field_' + guid).hide('slow').parent().remove();
					reorder_custom_fields();
				},
			});
		}
	});
});

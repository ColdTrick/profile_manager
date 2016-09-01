elgg.provide('elgg.profile_manager');

elgg.profile_manager.init_admin = function() {
	elgg.profile_manager.filter_custom_fields(0);
	
	$('#custom_fields_ordering').sortable({
		update: function() {
			elgg.profile_manager.reorder_custom_fields();
		},
		opacity: 0.6,
		tolerance: 'pointer',
		items: 'li'
	});

	$('#custom_fields_category_list_custom .elgg-list').sortable({
		update: function() {
			elgg.action('profile_manager/categories/reorder?' + $('#custom_fields_category_list_custom .elgg-list').sortable('serialize'));
		},
		opacity: 0.6,
		tolerance: 'pointer',
		items: 'li',
		handle: '.elgg-icon-drag-arrow'
	});

	$('#custom_profile_field_category_0, #custom_fields_category_list_custom .elgg-item').droppable({
		accept: '#custom_fields_ordering .elgg-item',
		hoverClass: 'droppable-hover',
		tolerance: 'pointer',
		drop: function(event, ui) {
			var dropped_on = $(this).attr('id');
			var dragged_field = $(ui.draggable);
			elgg.profile_manager.change_field_category(dragged_field, dropped_on);
		}
	});
	
	$(document).on('click', '#custom_fields_category_list_custom .category-filter', function() {
		elgg.profile_manager.filter_custom_fields($(this).data().guid);
	});
	
	$(document).on('click', '.field_config_metadata_option_disabled, .field_config_metadata_option_enabled', elgg.profile_manager.toggle_option);
	
	$(document).on('click', '.profile-manager-remove-field', function() {
		if (confirm(elgg.echo('profile_manager:actions:delete:confirm'))) {
			elgg.profile_manager.remove_field($(this).data().guid);
		}
	});
};

elgg.profile_manager.toggle_option = function(event) {
	var $button = $(this);
	
	var field = $button.data().field;
	var guid = $button.data().guid;
	elgg.action('profile_manager/toggleOption', {
		data: {
			guid: guid,
			field: field
		},
		success: function(data) {
			if (data.status === 0) {
				$button.toggleClass('field_config_metadata_option_disabled field_config_metadata_option_enabled');
			}
		},
	});
	
	event.preventDefault();
};

elgg.profile_manager.reorder_custom_fields = function() {
	elgg.action('profile_manager/reorder?' + $('#custom_fields_ordering').sortable('serialize'));
};

elgg.profile_manager.remove_field = function(guid) {
	elgg.action('profile_manager/delete', {
		data: {
			guid: guid
		},
		success: function(data) {
			if (data.status === 0) {
				$('#custom_profile_field_' + guid).hide('slow').parent().remove();
				elgg.profile_manager.reorder_custom_fields();
			}
		},
	});
};

elgg.profile_manager.filter_custom_fields = function(category_guid) {
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

elgg.profile_manager.change_field_type = function() {
	var selectedType = $('#custom_fields_form select[name="metadata_type"]').val();
	
	$('#custom_fields_form .custom_fields_form_field_option').prop('disabled', true);
	$('#custom_fields_form .field_option_enable_' + selectedType).prop('disabled', false);
};

elgg.profile_manager.change_field_category = function(field, category_guid) {
	var field_guid = $(field).attr('id').replace('elgg-object-','');
	category_guid = category_guid.replace('elgg-object-','').replace('custom_profile_field_category_', '');
	
	elgg.action('profile_manager/changeCategory', {
		data: {
			guid: field_guid,
			category_guid: category_guid
		},
		success: function(data) {
			if (data.status === 0) {
				if (category_guid === 0) {
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
				
				elgg.profile_manager.filter_custom_fields(current_cat_guid);
			}
		},
	});

};

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init_admin);
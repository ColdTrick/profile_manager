<?php
	
	$plugin_graphics_folder = elgg_get_site_url() . "mod/profile_manager/graphics/"; 

?>
#custom_fields_ordering {
	width: 518px;
}

.elgg-button-action.profile-manager-popup {
	float: right;
	padding-top: 0;
	padding-bottom: 0;
	margin: 0;
}

.custom_fields_lists_green {
	border-color: green !important; 
}

#custom_fields_category_list .droppable-hover{
	background: #BBDAF7;
}

.custom_fields_category,
.custom_profile_type  {
	border: 1px solid #CCCCCC;
	margin-bottom: 2px;
	padding: 1px;
	word-wrap: break-word;
	float: left;
}

.custom_profile_type {
	border-left: 1px solid #CCCCCC;
}

.custom_profile_type_description {
	display: none;
	margin-bottom: 5px;
	padding-bottom: 5px;
	border-bottom: 1px dotted #CCCCCC;
}

.custom_fields_category_selected {
	border-color: #4690D6;
}

.custom_fields_category_edit,
.custom_profile_type_edit {
	cursor: pointer;
	width: 16px;
	height: 16px;
	background: url(<?php echo $plugin_graphics_folder; ?>edit.png);
	margin-top: 1px;
	float: right;
}

.custom_fields_category_delete_button,
.custom_fields_profile_type_delete_button {
	display: none;
}

#custom_fields_category_list_custom .elgg-item {
	margin: 0px;
}

#custom_fields_category_list_custom .custom_fields_category { 
	cursor: move;
	margin: 3px;
}

#custom_fields_ordering .custom_field{
	border: 1px solid #CCCCCC;
	cursor: move;
	padding: 5px;
}

.custom_fields_forms {
	display: none;
}

#custom_fields_form, 
#custom_fields_category_form,
#custom_fields_profile_type_form {
	width: 700px;
}

#custom_fields_ordering.ui-sortable {
	min-height: 0px;
}

#custom_fields_category_list_custom .ui-sortable-helper,
#custom_fields_ordering .ui-sortable-helper {
	width: 100%;
}

.custom_field_handle {
	background: url("<?php echo $plugin_graphics_folder; ?>custom_profile_field.png");
	width: 16px;
	height: 16px;
	cursor: pointer;
	float: left;
	margin-right: 5px;
}

.metadata_config_right{
	float: right;
}

.metadata_config_left{
	float: left;
}

.metadata_config_left_extra{
	display:none;
}

.metadata_config_right_status {
	width: 16px;
	height: 13px;
	display: inline-block;
	cursor: default;
	background: url(<?php echo $plugin_graphics_folder; ?>field_metadata_status.png);
}

.metadata_config_right_status_enabled{
	background-position: 0 -16px;
	cursor: pointer;
}

.metadata_config_right_status_disabled{
	background-position: 0 -32px;
	cursor: pointer;
}


#restoreForm {
	display: none;
}

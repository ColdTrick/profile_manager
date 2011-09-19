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

#custom_fields_category_list_custom .droppable-hover{
	background: #000000;
}

#custom_fields_category_list_custom .droppable-hover a{
	color: #FFFFFF;
}

#custom_profile_field_category_all,
#custom_profile_field_category_all,
#custom_profile_field_category_0,
#custom_fields_category_list_custom .elgg-item,
#custom_fields_profile_types_list_custom .elgg-item {
	border: 1px solid #CCCCCC;
	margin: 0 2px 0 0;
	padding: 5px;
	word-wrap: break-word;
	float: left;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

#custom_fields_category_list_custom .custom_fields_category_selected {
	background: #BBBBBB;
}
.custom_profile_type .elgg-icon,
.custom_fields_category .elgg-icon {
	float: right;
	cursor: pointer;
}

.custom_fields_category .elgg-icon-drag-arrow {
	cursor: move;
	float: left;
}

.custom_profile_type_description {
	display: none;
	margin-bottom: 5px;
	padding-bottom: 5px;
	border-bottom: 1px dotted #CCCCCC;
}

#custom_fields_ordering .elgg-item {
	background: #FFFFFF;
}

#custom_fields_ordering .custom_field{
	border: 1px solid #CCCCCC;
	cursor: move;
	padding: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.custom_fields_forms {
	display: none;
}

#custom_fields_form, 
#custom_fields_category_form,
#custom_fields_profile_type_form {
	width: 700px;
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

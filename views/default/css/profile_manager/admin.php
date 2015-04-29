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
.custom_field .elgg-icon,
.custom_profile_type .elgg-icon,
.custom_fields_category .elgg-icon {
	cursor: pointer;
	vertical-align: text-bottom;
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

.field_config_metadata_option {
	width: 16px;
	height: 13px;
	display: inline-block;
	cursor: default;
	background: url(<?php echo $plugin_graphics_folder; ?>field_metadata_status.png);
}

.field_config_metadata_option_enabled{
	background-position: 0 -16px;
	cursor: pointer;
}

.field_config_metadata_option_disabled{
	background-position: 0 -32px;
	cursor: pointer;
}

.custom_fields_add_form_table,
.custom_fields_add_form_table_left {
	width: 100%;
}

.custom_fields_add_form_table_right {
	white-space: nowrap;
}

.custom_fields_add_form_table_right label{
	font-size:inherit;
	font-weight:inherit;
}
.custom_fields_add_form_table_right .elgg-input-checkbox{
	vertical-align: middle;
}

.profile-manager-user-summary-config {
	border-collapse: separate;
    border-spacing: 10px;
}

.profile-manager-user-summary-config td {
	padding: 5px;
}

.profile-manager-user-summary-config-name {
	width: 1%;
	white-space: nowrap;
	font-weight: bold;
	background: #CCCCCC;
	border: 2px solid #CCCCCC;
}

.profile-manager-user-summary-config-container {
	border: 2px dashed #CCCCCC;
}

.profile-manager-user-summary-config-container:hover {
	border: 2px solid #CCCCCC;
	background: #CCCCCC;
}

.profile-manager-user-summary-config-container-info {
	color: #BBBBBB;
}

.profile-manager-user-summary-config-container:hover .profile-manager-user-summary-config-container-info {
	visibility: hidden;
}

.elgg-icon-profile-manager-user-summary-config-add {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) no-repeat left -882px;
	cursor: pointer;
}

#profile-manager-user-summary-config-options {
	display: none;
}

.profile-manager-user-summary-config-options {
	width: 100px;
}

.profile-manager-user-summary-config-options-delete {
	color: red;
}

#profile-manager-user-summary-preview {
	width: 100%;
	min-height: 250px;
	overflow: hidden;
}

#profile-manager-user-summary-preview:hover {
	overflow: auto;
}
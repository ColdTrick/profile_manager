<?php 
	/**
	* Profile Manager
	* 
	* CSS
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
?>
#custom_fields_ordering {
	width: 518px;
	float: left;
}

.custom_fields_ordering_group {
	width: inherit !important;
	float: none !important;
}

#custom_fields_lists{
	width: 200px;
	float: right;
}

.custom_fields_lists_green {
	border-color: green !important; 
}

#custom_fields_category_list .ui-sortable{
	min-height: 0px;
}

#custom_fields_category_list .droppable-hover{
	background: #BBDAF7;
}

.custom_fields_category,
.custom_profile_type  {
	width: 100%;
	border: 1px solid #CCCCCC;
	border-left: 5px solid #CCCCCC;
	margin-bottom: 2px;
	padding: 1px;
	word-wrap: break-word;
	background-color: white; /* fix so pickup of draggable will work in IE (7) */
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
	background: url(<?php echo $vars['url']; ?>mod/profile_manager/_graphics/edit.png);
	margin-top: 1px;
	float: right;
}

.custom_fields_category_delete_button,
.custom_fields_profile_type_delete_button {
	display: none;
}

#custom_fields_category_list_custom .custom_fields_category { 
	cursor: move;
}

#custom_fields_ordering .search_listing {
	border: 1px solid #CCCCCC;
	cursor: move;
}

#custom_fields_ordering .search_listing_icon img {
	width: 16px;
	cursor: pointer;
}

#custom_fields_ordering .search_listing_info {
	min-height: 0px;
	margin-left: 25px;
	color: #333333;
}

#custom_fields_form, 
#custom_fields_category_form,
#custom_fields_profile_type_form {
	display: none;
}

#custom_fields_ordering.ui-sortable {
	min-height: 0px;
}
#custom_fields_category_list_custom .ui-sortable-helper,
#custom_fields_ordering .ui-sortable-helper {
	width: 100%;
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
	background: url(<?php echo $vars['url']; ?>mod/profile_manager/_graphics/field_metadata_status.png);
}

.metadata_config_right_status_enabled{
	background-position: 0 -16px;
	cursor: pointer;
}

.metadata_config_right_status_disabled{
	background-position: 0 -32px;
	cursor: pointer;
}

.datepicker_hidden{
	display: none;
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
.custom_fields_add_form_table_right .input-checkboxes{
	vertical-align: middle;
}

/* actions */
.custom_profile_fields_actions_list td{
	vertical-align: middle;
	padding-left: 5px;
	font-size:90%;
}

#restoreForm {
	display: none;
}

/* end actions */

.custom_fields_more_info {
	width: 14px;
	height: 14px;
	float: right;
	background: url(<?php echo $vars['url']; ?>_graphics/icon_customise_info.gif);
	cursor: pointer;
}

.custom_fields_more_info_text {
	display:none;
}

#custom_fields_more_info_tooltip {
	position:absolute;
	border:1px solid #333333;
	background:#e4ecf5;
	color:#333333;
	padding:5px;
	display:none;
	width: 250px;
	line-height: 1.2em;
	font-size: 90%;
}

/* fix for max-height multi-select drop down*/
.ui-dropdownchecklist-dropcontainer {
	max-height: 150px;
}
/* end fix */

/* user details */
#custom_fields_userdetails {
	margin: 2px 0;
}

#custom_fields_userdetails h3 {
	padding: 1px;
	border-bottom: 1px solid #CCCCCC;
	white-space: nowrap;
	overflow: hidden;
}


.ui-accordion-header {
	
	border: 1px solid #CCCCCC;
	cursor: pointer;
	margin-top:2px;
}

.ui-accordion-header:hover {
	background: #DEDEDE;
}

.ui-accordion-header .accordion-icon {
	margin-top: 1px;
	background: url(<?php echo $vars['url']; ?>mod/profile_manager/_graphics/accordion.png) no-repeat -16px 0;
	width: 16px;
	height: 16px;
	float: left;
}

.ui-accordion-header:hover .accordion-icon{
	background-position: -32px 0;
}


.ui-accordion-header.selected .accordion-icon {
	background-position: 0 0;
}

.submit_button {

	width: 1;  /* IE table-cell margin fix */
    overflow: visible; /* IE table-cell margin fix */
}
/* non_editables */

.hidden_non_editable {
	display: none;
}
/* end non_editables */

/* full profile */
#custom_profile_fields_full_profile_icon {
	
	padding: 10px 20px;
}

#custom_profile_fields_full_profile_details {
	width: 100%;
}

#custom_profile_fields_full_profile_details h3 {
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	border: none;
	background:#E4E4E4 none repeat scroll 0 0;
	color:#333333;
	font-size:1.1em;
	line-height:1em;
	margin:0 0 10px;
	padding:5px;
}

#custom_profile_fields_full_profile_details .profile_status {
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	background:#E3E3ED none repeat scroll 0 0;
	line-height:1.2em;
	padding:2px 4px;
}

.profile_manager_profile_edit_tab_content,
li.custom_fields_edit_profile_category {
	display: none;
}

/* Profile Manager Members Search Form */
#profile_manager_members_search_form{
	float: left; 
	width: 40%;
}

#profile_manager_members_search_form h3{
	cursor: pointer;
}

#members_search_result, 
#members_search_loader {
	float: right; 
	width: 55%;
}

#members_search_result_query {
	display: none;
}

.profile_manager_members_wait{
	cursor: wait !important;
}

/* registration form mandatory fields */

#register-box .profile_manager_register_missing {
	border: 1px solid red;
}

#register-box.table_layout {
	width: 98%;
	background: none;
}

#register-box.table_layout table {
	width: 100%;
}

#register-box.table_layout label {
	font-size: 1em;
	color: #333333;
}

#register-box.table_layout input[type="text"],
#register-box.table_layout input[type="password"] {
    margin: 0 0 5px;
}

#register-box.table_layout td {
	width: 50%;
	padding-right: 10px;
}

#profile_manager_register_tabbed li,
.profile_manager_register_category {
	display: none;
}
#profile_manager_register_right {
	float: right;
}

/* end registration form */

/* widgets */
#widget_profile_completeness_container {
	border: 1px solid #AAAAAA;
	position: relative;
}

#widget_profile_completeness_progress {
	position: absolute;
	line-height: 20px;
	font-weight: bold;
	width: 100%;
	text-align: center;
}

#widget_profile_completeness_progress_bar {
	background: #00FF00;
	height: 20px;
}


.profile_noindex_explain {
	font-size: 90%;
	color: #cccccc;
}
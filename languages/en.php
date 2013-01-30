<?php 
	/**
	* Profile Manager
	* 
	* English language
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$english = array(
					
		// entity names
		'item:object:custom_profile_field' => 'Custom Profile Field',
		'item:object:custom_profile_field_category' => 'Custom Profile Field Category',
		'item:object:custom_profile_type' => 'Custom Profile Type',
		'item:object:custom_group_field' => 'Custom Group Field',
	
		'profile:custom_profile_type' => 'Custom Profile Type',
		
		// admin menu 
		'admin:appearance:group_fields' => "Edit Group Fields",
		'admin:appearance:export_fields' => "Export Profile Data",
		'admin:appearance:user_summary_control' => "User Summary Control",

		'admin:groups' => "Groups",
		'admin:groups:export' => "Export groups",
		
		'admin:users:export' => "Export users",
		'admin:users:inactive' => "List inactive users",
	
		// plugin settings
		'profile_manager:settings:registration' => 'Registration',
		'profile_manager:settings:edit_profile' => 'Edit Profile',
		'profile_manager:settings:view_profile' => 'View Profile',
		'profile_manager:settings:other' => 'Other',
	
		'profile_manager:settings:profile_icon_on_register' => 'Add mandatory profile icon input field on register form',
		'profile_manager:settings:simple_access_control' => 'Show just one access control dropdown on edit profile form',
		'profile_manager:settings:default_profile_type' => "Default profile type on registration form",
		'profile_manager:settings:hide_profile_type_default' => "Hide the 'Default' profile type on registration form",
	
		'profile_manager:settings:hide_non_editables' => 'Hide the non editable fields from the Edit Profile form',
	
		'profile_manager:settings:edit_profile_mode' => "How to show the 'edit profile' screen",
		'profile_manager:settings:edit_profile_mode:list' => "List",
		'profile_manager:settings:edit_profile_mode:tabbed' => "Tabbed",
	
		'profile_manager:settings:show_profile_type_on_profile' => "Show the users profile type on the profile",
	
		'profile_manager:settings:display_categories' => 'Select how the different categories are displayed on the profile',
		'profile_manager:settings:display_categories:option:plain' => 'Plain',
		'profile_manager:settings:display_categories:option:accordion' => 'Accordion',
	
		'profile_manager:settings:display_system_category' => 'Show an extra category on the profile with systemdata (only for admins)',
	
		'profile_manager:settings:profile_type_selection' => 'Who can change the profile type?',
		'profile_manager:settings:profile_type_selection:option:user' => 'User',
		'profile_manager:settings:profile_type_selection:option:admin' => 'Admin only',

		'profile_manager:settings:description_position' => 'Where to position the description ("About me") field',
		'profile_manager:settings:user_summary_control' => 'Let Profile Manager control the user summary / listing view',
		
		'profile_manager:settings:enable_profile_completeness_widget' => "Enable the profile completeness widget",
		'profile_manager:settings:enable_username_change' => "Allow users to change their username in settings",
		'profile_manager:settings:enable_username_change:option:admin' => "Admin only",
		'profile_manager:settings:enable_site_join_river_event' => "Add a river event when people join this site",
		
		'profile_manager:settings:registration:terms' => "To show an 'Accept terms' field on the registration page, please fill in the URL to the terms below",
		'profile_manager:settings:registration:extra_fields' => "Where to show extra profile fields",
		'profile_manager:settings:registration:extra_fields:extend' => "Below default registration form",
		'profile_manager:settings:registration:extra_fields:beside' => "Beside registration form",
		'profile_manager:settings:registration:free_text' => "Enter extra text to show on the registration page",
		
		// Field Configuration
		'profile_manager:admin:metadata_name' => 'Name',	
		'profile_manager:admin:metadata_label' => 'Label',
		'profile_manager:admin:metadata_hint' => 'Hint',
		'profile_manager:admin:metadata_description' => 'Description',
		'profile_manager:admin:metadata_label_translated' => 'Label (Translated)',
		'profile_manager:admin:metadata_label_untranslated' => 'Label (Untranslated)',
		'profile_manager:admin:metadata_options' => 'Options (comma separated)',
		'profile_manager:admin:field_type' => "Field Type",
		'profile_manager:admin:options:datepicker' => 'Datepicker',
		'profile_manager:admin:options:pm_datepicker' => 'Datepicker (Profile Manager Style)',
		'profile_manager:admin:options:dropdown' => 'Dropdown',
		'profile_manager:admin:options:radio' => 'Radio',
		'profile_manager:admin:options:multiselect' => 'MultiSelect',
		'profile_manager:admin:options:file' => 'File',
		'profile_manager:admin:options:pm_rating' => 'Rating',
		
		'profile_manager:admin:additional_options' => 'Additional options',
		'profile_manager:admin:show_on_register' => 'Show on register form',	
		'profile_manager:admin:mandatory' => 'Mandatory',
		'profile_manager:admin:user_editable' => 'User can edit this field',
		'profile_manager:admin:output_as_tags' => 'Show on profile as tags',
		'profile_manager:admin:admin_only' => 'Admin only field',
		'profile_manager:admin:count_for_completeness' => 'Count this field in profile completeness widget',
		'profile_manager:admin:blank_available' => 'Field has a blank option',		
		'profile_manager:admin:option_unavailable' => 'Option unavailable',
	
		// field options additionals description
		'profile_manager:admin:show_on_register:description' => "If you want this field to be on the register form.",	
		'profile_manager:admin:mandatory:description' => "If you want this field to be mandatory (only applies to the register form).",
		'profile_manager:admin:user_editable:description' => "If set to 'No' users can't edit this field (handy when data is managed in an external system).",
		'profile_manager:admin:output_as_tags:description' => "Data output will be handle as tags (only applies on user profile).",
		'profile_manager:admin:admin_only:description' => "Select 'Yes' if field is only available for admins.",
		'profile_manager:admin:blank_available:description' => "Select 'Yes' if a blank option should be added to the field options",	
	
		// profile fields
		'profile_manager:profile_fields:list:title' => "Profile Fields",	
	
		'profile_manager:profile_fields:no_fields' => "Currently no fields are configured using the Profile Manager plugin. Add your own or import with one of the actions below.",
		
		'profile_manager:profile_fields:add' => "Add a new profile field",
		'profile_manager:profile_fields:edit' => "Edit a profile field",
		'profile_manager:profile_fields:add:description' => "Here you can edit the fields a user can edit on his/her profile",
	
		// group fields
		'profile_manager:group_fields:list:title' => "Group Profile Fields",	
	
		'profile_manager:group_fields:add:description' => "Here you can edit the fields that show on a group profile page",
		'profile_manager:group_fields:add' => "Add a new group profile field",
		'profile_manager:group_fields:edit' => "Edit a group profile field",
	
		// Custom fields categories
		'profile_manager:categories:add' => "Add a new category",
		'profile_manager:categories:edit' => "Edit a category",
		'profile_manager:categories:list:title' => "Categories",
		'profile_manager:categories:list:default' => "Default",
		'profile_manager:categories:list:system' => "System (admin only)",	
		'profile_manager:categories:list:view_all' => "View all fields",
		'profile_manager:categories:list:no_categories' => "No categories defined",
		'profile_manager:categories:delete:confirm' => "Are you sure you wish to delete this category?",
		
		// Custom Profile Types
		'profile_manager:profile_types:add' => "Add a new profile type",
		'profile_manager:profile_types:edit' => "Edit a profile type",
		'profile_manager:profile_types:list:title' => "Profile Types",
		'profile_manager:profile_types:list:no_types' => "No profile types defined",
		'profile_manager:profile_types:delete:confirm' => "Are you sure you wish to delete this profile type?",
		'profile_manager:user_details:profile_type' => "Profile Type",
		
		// User Summary Control
		'profile_manager:user_summary_control:config' => "Configuration",
		'profile_manager:user_summary_control:info' => "Add fields to the different containers and see in the preview the result of the configuration. If you are satisfied you can 'Save' the configuration.",
		
		'profile_manager:user_summary_control:container:title' => "Title",
		'profile_manager:user_summary_control:container:entity_menu' => "Entity Menu",
		'profile_manager:user_summary_control:container:subtitle' => "Subtitle",
		'profile_manager:user_summary_control:container:content' => "Content",
		
		'profile_manager:user_summary_control:options:spacers' => "Spacers",
		'profile_manager:user_summary_control:options:spacers:new_line' => "New line",
		'profile_manager:user_summary_control:options:spacers:space' => "Space",
		'profile_manager:user_summary_control:options:spacers:dash' => "-",
		
		// profile manager inactive users
		'profile_manager:admin:users:inactive:last_login' => "Last login before",
		'profile_manager:admin:users:inactive:list' => "Inactive users",
		'profile_manager:admin:users:inactive:never' => "Never",
		'profile_manager:admin:users:inactive:download' => "Download",
	
		// admin actions
		'profile_manager:actions:title' => 'Actions',
	
		// Reset
		'profile_manager:actions:reset:description' => 'Removes all custom profile fields',
		'profile_manager:actions:reset:confirm' => 'Are you sure you wish to reset all profile fields?',
		'profile_manager:actions:reset:error:unknown' => 'Unknown error occurred while resetting all profile fields',
		'profile_manager:actions:reset:error:wrong_type' => 'Wrong profile field type (group or profile)',
		'profile_manager:actions:reset:success' => 'Reset succesful',
	
		// import from custom
		'profile_manager:actions:import:from_custom' => 'Import custom fields',
		'profile_manager:actions:import:from_custom:description' => 'Imports previous defined (with default Elgg functionality) profile fields',
		'profile_manager:actions:import:from_custom:confirm' => 'Are you sure you wish to import custom fields?',
		'profile_manager:actions:import:from_custom:no_fields' => 'No custom fields available for import',
		'profile_manager:actions:import:from_custom:new_fields' => 'Succesfully imported <b>%s</b> new fields',
	
		// import from default
		'profile_manager:actions:import:from_default' => 'Import default fields',
		'profile_manager:actions:import:from_default:description' => "Imports Elgg's default fields",
		'profile_manager:actions:import:from_default:confirm' => 'Are you sure you wish to import default fields?',
		'profile_manager:actions:import:from_default:no_fields' => 'No default fields available for import',
		'profile_manager:actions:import:from_default:new_fields' => 'Succesfully imported <b>%s</b> new fields',
		'profile_manager:actions:import:from_default:error:wrong_type' => 'Wrong profile field type (group or profile)',
	
		// Export
		'profile_manager:actions:export' => "Export",
		'profile_manager:actions:export:description' => "Export profile data to a csv file",
		'profile_manager:export:title' => "Export Profile Data",
		'profile_manager:export:description:custom_profile_field' => "This function will export all <b>user</b> metadata based on selected fields.",
		'profile_manager:export:description:custom_group_field' => "This function will export all <b>group</b> metadata based on selected fields.",
		'profile_manager:export:list:title' => "Select the fields which you want to be exported",
		'profile_manager:export:nofields' => "No custom profile fields available for export",
	
		// Configuration Backup and Restore
		'profile_manager:actions:configuration:backup' => "Backup",
		'profile_manager:actions:configuration:backup:description' => "Backup the configuration of these fields (categories and types are not backed up)",
		'profile_manager:actions:configuration:restore' => "Restore",
		'profile_manager:actions:configuration:restore:description' => "Restore a previously backed up configuration file (<b>you will loose relations between fields and categories</b>)",
		
		'profile_manager:actions:configuration:restore:upload' => "Restore",
	
		'profile_manager:actions:restore:success' => "Restore successful",
		'profile_manager:actions:restore:error:deleting' => "Error while restoring: couldn't delete current fields",	
		'profile_manager:actions:restore:error:fieldtype' => "Error while restoring: fieldtypes do not match",
		'profile_manager:actions:restore:error:corrupt' => "Error while restoring: backup file seems to be corrupt or information is missing",
		'profile_manager:actions:restore:error:json' => "Error while restoring: invalid json file",
		'profile_manager:actions:restore:error:nofile' => "Error while restoring: no file uploaded",
	
		// new
		'profile_manager:actions:new:success' => 'Succesfully added new custom profile field',	
		'profile_manager:actions:new:error:metadata_name_missing' => 'No metadata name provided',	
		'profile_manager:actions:new:error:metadata_name_invalid' => 'Metadata name is an invalid name',	
		'profile_manager:actions:new:error:metadata_options' => 'You need to enter options when using this type',	
		'profile_manager:actions:new:error:unknown' => 'Unknown error occurred when saving a new custom profile field',
		'profile_manager:action:new:error:type' => 'Wrong profile field type (group or profile)',
		
		// edit
		'profile_manager:actions:edit:error:unknown' => 'Error fetching profile field data',
	
		//delete
		'profile_manager:actions:delete:confirm' => 'Are you sure you wish to delete this field?',
		'profile_manager:actions:delete:error:unknown' => 'Unknown error occurred while deleting',

		// toggle option
		'profile_manager:actions:toggle_option:error:unknown' => 'Unknown error occurred while changing the option',
	
		// category to field
		'profile_manager:actions:change_category:error:unknown' => "An unknown error occured while changing the category",
	
		// add category
		'profile_manager:action:category:add:error:name' => "No name or an invalid name provided for the category",
		'profile_manager:action:category:add:error:object' => "Error while creating the category object",
		'profile_manager:action:category:add:error:save' => "Error while saving the category object",
		'profile_manager:action:category:add:succes' => "The category was created succesfully",
	
		// delete category
		'profile_manager:action:category:delete:error:guid' => "No GUID provided",
		'profile_manager:action:category:delete:error:type' => "The provided GUID is not a custom profile field category",
		'profile_manager:action:category:delete:error:delete' => "An error occured while deleting the category",
		'profile_manager:action:category:delete:succes' => "The category was deleted succesfully",
	
		// add profile type
		'profile_manager:action:profile_types:add:error:name' => "No name or an invalid name provided for the Custom Profile Type",
		'profile_manager:action:profile_types:add:error:object' => "Error while creating the Custom Profile Type",
		'profile_manager:action:profile_types:add:error:save' => "Error while saving the Custom Profile Type",
		'profile_manager:action:profile_types:add:succes' => "The Custom profile Type was created succesfully",
		
		// delete profile type
		'profile_manager:action:profile_types:delete:error:guid' => "No GUID provided",
		'profile_manager:action:profile_types:delete:error:type' => "The provided GUID is not an Custom Profile Type",
		'profile_manager:action:profile_types:delete:error:delete' => "An unknown error occured while deleting the Custom Profile Type",
		'profile_manager:action:profile_types:delete:succes' => "The Custom Profile Type was deleted succesfully",
		
		// change username action
		'profile_manager:action:username:change:succes' => "Successfully changed your username",
	
		// Tooltips
		'profile_manager:tooltips:profile_field' => "
			<b>Profile Field</b><br />
			Here you can add a new profile field.<br /><br />
			If you leave the label empty, you can internationalize the profile field label (<i>profile:[name]</i>).<br /><br />
			Use the hint field to supply on input forms (register and profile/group edit) a hoverable icon with a field description.
			If you leave the hint empty, you can internationalize the hint (<i>profile:hint:[name]</i>).<br /><br />
			Options are only mandatory for fieldtypes <i>Dropdown, Radio and MultiSelect</i>.
		",
		'profile_manager:tooltips:profile_field_additional' => "
			<b>Show on register</b><br />
			If you want this field to be on the register form.<br /><br />
			
			<b>Mandatory</b><br />
			If you want this field to be mandatory (only applies to the register form).<br /><br />
			
			<b>User editable</b><br />
			If set to 'No' users can't edit this field (handy when data is managed in an external system).<br /><br />
			
			<b>Show as tags</b><br />
			Data output will be handle as tags (only applies on user profile).<br /><br />
			
			<b>Admin only field</b><br />
			Select 'Yes' if field is only available for admins.
		",
		'profile_manager:tooltips:category' => "
			<b>Category</b><br />
			Here you can add a new profile category.<br /><br />
			If you leave the label empty, you can internationalize the category label (<i>profile:categories:[name]</i>).<br /><br />
			
			If Profile Types are defined you can choose on which profile type this category applies. If no profile is specified, the category applies to all profile types (even undefined).
		",
		'profile_manager:tooltips:category_list' => "
			<b>Categories</b><br />
			Shows a list of all configured categories.<br /><br />
			
			<i>Default</i> is the category that applies to all profiles.<br /><br />
			
			Add fields to these categories by dropping them on the categories.<br /><br />
			
			Click the category label to filter the visible fields. Clicking view all fields shows all fields.<br /><br />
			
			You can also change the order of the categories by dragging them (<i>Default can't be dragged</i>. <br /><br />
			
			Click the edit icon to edit the category.
		",
		'profile_manager:tooltips:profile_type' => "
			<b>Profile Type</b><br />
			Here you can add a new profile type.<br /><br />
			If you leave the label empty, you can internationalize the profile type label (<i>profile:types:[name]</i>).<br /><br />
			Enter a description which users can see when selecting this profile type or leave it empty to internationalize (<i>profile:types:[name]:description</i>).<br /><br />
			
			If Categories are defined you can choose which categories apply to this profile type.
		",
		'profile_manager:tooltips:profile_type_list' => "
			<b>Profile Types</b><br />
			Shows a list of all configured profile types.<br /><br />
			Click the edit icon to edit the profile type.
		",
		'profile_manager:tooltips:actions' => "
			<b>Actions</b><br />
			Various actions related to these profile fields.
		",
	
		// widgets
		'widgets:profile_completeness:title' => 'Profile Completeness',
		'widgets:profile_completeness:description' => 'Show the profile completeness',
		'widgets:profile_completeness:view:tips' => 'Tip! Update your %s to improve the Profile Completeness.',
		'widgets:profile_completeness:view:complete' => 'Congratulations! Your profile is 100% complete!',
		
		'widgets:register:title' => "Register",
		'widgets:register:description' => "Show a register box",
		'widgets:register:loggedout' => "You need to be logged out to use this widget",
	
		// datepicker		
		'profile_manager:datepicker:trigger' => 'Select a date',
		'profile_manager:datepicker:output:dateformat' => '%a %d %b %Y', // For available notations see http://nl.php.net/manual/en/function.strftime.php
		'profile_manager:datepicker:input:localisation' => '', // change it to the available localized js files in custom_profile_fields/vendors/jquery.datepick.package-3.5.2 (e.g. jquery.datepick-nl.js), leave blank for default 
		'profile_manager:datepicker:input:dateformat' => '%m/%d/%Y', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format
		'profile_manager:datepicker:input:dateformat_js' => 'mm/dd/yyyy', // Notation is based on strftime, but must result in output like http://keith-wood.name/datepick.html#format

		'profile_manager:input:multi_select:empty_text' => 'Please select ...',
	
		// Edit profile => profile type selector
		'profile_manager:profile:edit:custom_profile_type:label' => "Select your profile type",
		'profile_manager:profile:edit:custom_profile_type:description' => "Description of selected profile type",
		'profile_manager:profile:edit:custom_profile_type:default' => "Default",
	
		// non_editable
		'profile_manager:non_editable:info' => 'This field can not be edited',
		
		// register form mandatory notice
		'profile_manager:register:mandatory' => "Items marked with a * are mandatory",
		
		// register profile icon
		'profile_manager:register:profile_icon' => 'This site requires you to upload a profile icon',
		
		// register accept terms
		'profile_manager:registration:accept_terms' => "I have read and accept the %sTerms of Service%s",
	
		// simple access control
		'profile_manager:simple_access_control' => 'Select who can view your profile information',
	
		// register pre check
		'profile_manager:register_pre_check:missing' => 'The next field must be filled: %s',
		'profile_manager:register_pre_check:terms' => 'You need to accept the terms to complete the registration',
		'profile_manager:register_pre_check:profile_icon:error' => 'Error uploading your profile icon (probably related to the file size)',
		'profile_manager:register_pre_check:profile_icon:nosupportedimage' => 'Uploaded profile icon is not the right type (jpg, gif, png)',
	
		// Admin add user form
		'profile_manager:admin:adduser:notify' => "Notify user",
		'profile_manager:admin:adduser:use_default_access' => "Extra metadata created based on site default access level",
		'profile_manager:admin:adduser:extra_metadata' => "Add extra profile data",
		
		// change username form
		'profile_manager:account:username:button' => "Click to change your username",
		'profile_manager:account:username:info' => "Change your username. An icon will tell you if the username entered is valid and available.",
		
		// river events
		'river:join:site:default' => '%s joined the site',
	
		// login history
		'profile_manager:account:login_history' => "Login History",
		'profile_manager:account:login_history:date' => "Date",
		'profile_manager:account:login_history:ip' => "IP Address",
		
	
	);
	
	add_translation("en", $english);
	
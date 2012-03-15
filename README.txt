= Profile Manager =

Provides better use of profile fields, replaces (replace profile fields) and configurable group fields

== Contents ==

1. Features
2. TO DO
3. Known issues

== 1. Features ==
- importing default or custom fields
- ordering of custom fields (drag and drop)
- add profile types
- add categories (draggable reordering, drop fields on categories to add)
- adds pulldown, radio, multiselect, calendar and datepicker field types
- show on register form (profile fields only)
- show output as tags
- mandatory fields (for register form, profile fields only)
- mandatory profile icon on register form
- disallow editing of a specific field (applies to edit profile only)
- replace profile fields access control with just one profile access option
- backup / restore profile fields configuration
- export user profile (meta)data to csv
- a customized registration form
- control the fields shown on a user summary / listing view

== 2. TO DO ==
- categories and types for groups
- multilingual options (in pulldown, radio, multiselect)
- Default values for fields (user specified)
- Force empty fields on profile
- dependend fields
- check existence of input/output views (in get_categorized function)
- check if fieldtype is enabled (in get_categorized function)
- handle disabled fieldtype options (in get_categorized function)
- handle empty fields on group details (in get_categorized function)
- replace profile type description with longtext instead of plaintext
- add "modify once" option to fields. So user can only modify the first time. Only admin then will be able to change it.
- add "default access lvl"
- add "can change access lvl"
- tabbed profile details
- extend group and user search listing with info from profile manager
- add hint to default register form fields (username, email, password etc)
- review complete js
- review new field action (make better use of class constructors)
- export profile fields
	- time created (ts/date)
	- time last login (ts/date)
	- time last action (ts/date)
	- validate (yes/no)
	
- check trimmed required profile fields (space should not be accepted, js + hook)
- use elgg_get_config("icon_sizes") for mandatory profile icon upload
	
== 3. Known issues ==
- on register error backward maintaining selected profile icon is impossible due to security reasons 
- longtext with tinymce too small when on first hidden
- multiselect mandatory not js enforced on register form
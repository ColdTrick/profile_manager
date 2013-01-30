Profile Manager
===============

Improved management of user and group profile fields

Contents
--------

1. Features
2. ToDo
3. Known issues

1. Features
-----------

- importing default or custom fields
- ordering of custom fields (drag and drop)
- add profile types
- add categories (draggable reordering, drop fields on categories to add)
- adds dropdown, radio, multiselect and date field types
- show on register form (profile fields only)
- show output as tags
- mandatory fields (for register form, profile fields only)
- mandatory profile icon on register form
- disallow editing of a specific field (applies to edit profile only)
- replace profile fields access control with just one profile access option
- backup / restore profile fields configuration
- export user profile (meta)data to csv
- a customized registration form
- live check for valid username, email and password fields on registration form
- control the fields shown on a user summary / listing view
- a river event when user joins the site
- login history view on users statistics page
- admin listing + download of inactive users

- profile completeness widget
- register form widget

2. ToDo
-------

- categories and types for groups
- multilingual options (in dropdown, radio, multiselect)
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
- add hint to default register form fields (username, email, password etc)
- review complete js
- review new field action (make better use of class constructors)
- add profile icon on admin user create profile form (adduser)
- check trimmed required profile fields (space should not be accepted, 0 should be accepted, js + hook)
- be able to add new profile fields directly into a category
	
3. Known issues
---------------

- on register error backward maintaining selected profile icon is impossible due to security reasons 
- multiselect mandatory not js enforced on register form
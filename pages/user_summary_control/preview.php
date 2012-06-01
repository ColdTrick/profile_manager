<?php 

if($user = elgg_get_logged_in_user_entity()){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<?php echo elgg_view('page/elements/head'); ?>
	</head>
	<body>
			<?php echo elgg_view_entity_list(array($user), array("list_class" => "profile-manager-user-summary-preview"));?>
	</body>
</html>
<?php 
} else {
	forward();
}
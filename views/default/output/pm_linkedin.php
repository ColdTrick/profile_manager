<?php
/**
 * More info about linkedin profile button: https://developer.linkedin.com/plugins/member-profile
 */
$href = elgg_extract('value', $vars);

if (empty($href)) {
	return;
}

$name = "";
$page_owner = elgg_get_page_owner_entity();
if ($page_owner) {
	$name = $page_owner->name;
}

?>
<div class="profile-manager-output-linkedin">
	<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
	<script type="IN/MemberProfile" data-id="<?php echo $href; ?>" data-format="hover" data-related="false" data-text="<?php echo $name; ?>"></script>
</div>
<?php
/**
 * More info about follow me on twitter button: https://about.twitter.com/resources/buttons#follow
 */

$username = elgg_extract('value', $vars);

if (empty($username)) {
	return;
}

echo '<div class="profile-manager-output-twitter">';
echo elgg_view('output/url', [
	'href' => '//twitter.com/' . $username,
	'class' => 'twitter-follow-button',
	'data-show-count' => 'false',
	'data-size' => 'large',
	'text' => elgg_echo('profile_manager:pm_twitter:output:follow', [$username])
]);
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
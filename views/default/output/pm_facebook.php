<?php
/**
 * More info about facebook follow button: https://developers.facebook.com/docs/plugins/follow-button
 */

global $PROFILE_MANAGER_OUTPUT_FACEBOOK;
$href = elgg_extract('value', $vars);

if (empty($href)) {
	return;
}

echo '<div class="profile-manager-output-twitter">';
$attrs = [
	'class' => 'fb-follow',
	'data-href' => $href,
	'data-colorscheme' => 'light',
	'data-layout' => 'button',
	'data=show-faces' => 'false'
];
echo elgg_format_element('div', $attrs);
echo '</div>';

if (!isset($PROFILE_MANAGER_OUTPUT_FACEBOOK)) {
	$PROFILE_MANAGER_OUTPUT_FACEBOOK = true;
	echo <<<__FACEBOOK
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
__FACEBOOK;
}

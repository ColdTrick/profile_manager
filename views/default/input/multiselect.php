<?php
/**
 * Profile Manager
 *
 * Multiselect
 *
 * @package profile_manager
 * @author ColdTrick IT Solutions
 * @copyright Coldtrick IT Solutions 2009
 * @link http://www.coldtrick.com/
 */

if (elgg_is_xhr()) {
	echo elgg_format_element('link', ['rel' => 'stylesheet', 'href' => elgg_get_simplecache_url('input/multiselect.css')]);
} else {
	elgg_require_css('input/multiselect');
}

$vars['class'] = elgg_extract_class($vars, 'profile-manager-multiselect');

$vars['name'] .= '[]';
$vars['multiple'] = true;

$value = elgg_extract('value', $vars, []);
if (!is_array($value)) {
	$value = elgg_string_to_array((string) $value);
}

$vars['value'] = $value;

echo elgg_view('input/hidden', ['name' => $vars['name'], 'value' => '']);
echo elgg_view('input/select', $vars);

?>
<script type='module'>
	import MultiSelect from 'input/multiselect';
	MultiSelect.init("#<?php echo $vars['id']; ?>");
</script>

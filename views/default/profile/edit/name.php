<?php

// id profile_edit_form
?>
<div>
	<label><?php echo elgg_echo('user:name:label'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'name', 'value' => $vars['entity']->name)); ?>
</div>

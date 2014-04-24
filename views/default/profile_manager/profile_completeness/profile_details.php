<?php

$entity = elgg_get_page_owner_entity();
if ($entity) {
	echo elgg_view("profile_manager/profile_completeness/content", array("entity" => $entity, "hide_when_complete" => true));
}

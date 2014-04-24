<?php

$entity = $vars["entity"]->getOwnerEntity();

echo elgg_view("profile_manager/profile_completeness/content", array("entity" => $entity));
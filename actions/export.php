<?php
	/**
	* Profile Manager
	* 
	* export profile data action
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 
	admin_gatekeeper();

	$fielddelimiter = "|";
	
	$fieldtype = get_input("fieldtype");
	$fields = get_input("export");
	
	// We'll be outputting a CSV
	header("Content-Type: text/plain; charset: UTF-8");
		
	// It will be called export.csv
	header('Content-Disposition: attachment; filename="export.csv"');
	
	if(!empty($fieldtype) && !empty($fields)){
		if($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE || $fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
			$headers = "";
			foreach($fields as $field){
				if(!empty($headers)){
					$headers .= $fielddelimiter . " ";
				}
				$headers .= $field;
			}
			echo $headers . PHP_EOL;
			
			if($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE){
				$type = "user";
			} else {
				$type = "group";
			}
			
			$options = array(
				"type" => $type,
				"count" => true
			);
			
			$entities_count = elgg_get_entities($options);
			
			$options["count"] = false;
			$options["limit"] = $entities_count;
			
			$entities = elgg_get_entities($options);
			
			foreach($entities as $entity){
				$row = "";
				foreach($fields as $field){
					if(!empty($row)){
						$row .= $fielddelimiter . " ";
					}
					$field_data = $entity->$field;
					if(is_array($field_data)){
						$field_data = implode(",", $field_data);
					}
					$row .= $field_data; 
				}
				echo $row . PHP_EOL;
			}
		}
	}
	
	exit();

?>
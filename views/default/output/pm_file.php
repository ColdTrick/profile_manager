<?php 
	if($file_guid = $vars["value"]){
		
		if($file = get_entity($file_guid)){
			if(is_plugin_enabled("file")){
				echo "<a target='_blank' href='" . $file->getURL() . "'>" . $file->originalfilename . "</a>";
			} else {
				echo "<a target='_blank' href='" . $vars["url"] . "pg/profile_manager/file_download/" . $file->getGUID() . "'>" . $file->originalfilename . "</a>";
			}
		}
		 
	}
	
?>
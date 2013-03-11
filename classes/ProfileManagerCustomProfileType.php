<?php
	
	class ProfileManagerCustomProfileType extends ElggObject {
 			
		const SUBTYPE = "custom_profile_type";
		
		protected function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
			$this->attributes['container_guid'] = elgg_get_site_entity()->getGUID();
		}

		public function getTitle(){
			// make title
			$title = $this->metadata_label;

			if(empty($title)){
				$trans_key = "profile:types:" . $this->metadata_name;
				if($trans_key != elgg_echo($trans_key)){
					$title = elgg_echo($trans_key);
				} else {
					$title = $this->metadata_name;
				}
			}
			
			return $title;
		}	

		public function getDescription(){
			$description = $this->metadata_description;
			if(empty($description)){
				$trans_key = "profile:types:" . $this->metadata_name . ":description";
				if($trans_key != elgg_echo($trans_key)){
					$description = elgg_echo($trans_key);
				} 
			}
			
			return $description;
		}
	}
<?php
	class ProfileManagerCustomFieldCategory extends ElggObject {

		const SUBTYPE = "custom_profile_field_category";
		
		protected function initializeAttributes(){
			parent::initializeAttributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
			$this->attributes['container_guid'] =elgg_get_site_entity()->getGUID();
		}
			 
		public function getTitle(){
			// make title
			$title = $this->metadata_label;
			
			if(empty($title)){
				$trans_key = "profile:categories:" . $this->metadata_name;
				if($trans_key != elgg_echo($trans_key)){
					$title = elgg_echo($trans_key);
				} else {
					$title = $this->metadata_name;
				}
			}
			
			return $title;
		}	

		/**
		 * Returns an array of linked profile type guids
		 */
		public function getLinkedProfileTypes(){
			
			if($types = $this->getEntitiesFromRelationship(CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, true, false)){
				$result = array();
				
				foreach($types as $type){
					$result[] = $type->getGUID(); 
				}
			} else {
				// return 0 as the default
				$result = array(0);
			}
			
			return $result;
		}
	}
<?php 
	
	abstract class ProfileManagerCustomField extends ElggObject {
 		
		protected function initialise_attributes() {
			global $CONFIG;
			
			parent::initialise_attributes();
			
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = $CONFIG->site_guid;
			$this->attributes['container_guid'] = $CONFIG->site_guid;
		}
	 
		public function __construct($guid = null) {
			parent::__construct($guid);
		}
		
		public function getOptions($add_blank_option = false){
			$options = "";
			
			// get options
			if(!empty($this->metadata_options))	{
				
				$options = explode(",", $this->metadata_options);
				
				if(!$add_blank_option){
					if($this->blank_available == "yes"){	
						$add_blank_option = true;
					} 
				}
				
				if($this->metadata_type != "multiselect" && $add_blank_option){
					// optionally add a blank option to the field options
					array_unshift($options, "");
				}
			}
			
			return $options;
		}
	}
	
	class ProfileManagerCustomProfileField extends ProfileManagerCustomField {
 		
		const SUBTYPE = "custom_profile_field";
		
		protected function initialise_attributes() {
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
		}
		
		public function getTitle(){
			// make title
			$title = $this->metadata_label;
			
			if(empty($title)){
				$trans_key = "profile:" . $this->metadata_name;
				if($trans_key != elgg_echo($trans_key)){
					$title = elgg_echo($trans_key);
				} else {
					$title = $this->metadata_name;
				}
			}
			
			return $title;
		}	
	}

	class ProfileManagerCustomGroupField extends ProfileManagerCustomField {
 		
		const SUBTYPE = "custom_group_field";
		
		protected function initialise_attributes() {
			parent::initialise_attributes();
		}
	 
		public function getTitle(){
			// make title
			$title = $this->metadata_label;
			
			if(empty($title)){
				$trans_key = "groups:" . $this->metadata_name;
				if($trans_key != elgg_echo($trans_key)){
					$title = elgg_echo($trans_key);
				} else {
					$title = $this->metadata_name;
				}
			}
			
			return $title;
		}		
	}
	
	class ProfileManagerCustomProfileType extends ElggObject {
 		
		const SUBTYPE = "custom_profile_type";
		
		protected function initialise_attributes() {
			global $CONFIG;
			
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = $CONFIG->site_guid;
			$this->attributes['container_guid'] = $CONFIG->site_guid;
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
	
	class ProfileManagerCustomFieldCategory extends ElggObject {
 		
		const SUBTYPE = "custom_profile_field_category";
		
		protected function initialise_attributes() {
			global $CONFIG;
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = $CONFIG->site_guid;
			$this->attributes['container_guid'] = $CONFIG->site_guid;
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

?>
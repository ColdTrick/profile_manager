<?php 
	
	abstract class ProfileManagerCustomField extends ElggObject {
 		protected $meta_cache;
 		protected $meta_defaults = array(
 			"admin_only" => "no",
 			"mandatory" => "no", 
 			"show_on_register" => "no", 
 			"output_as_tags" => "no", 
 			"simple_search" => "no", 
 			"advanced_search" => "no",
 			"metadata_label" => NULL,
 			"category_guid" => NULL,
 			"metadata_hint" => NULL,
 			"metadata_options" => NULL
 			);
		
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
		
		protected function load($guid) {
			if (!parent::load($guid)) {
				return false;
			}
			
			if($metadata = get_metadata_for_entity($guid)){
				if (!is_array($this->meta_cache)) {
					$this->meta_cache = array();
				}
				foreach($metadata as $md){
					$this->meta_cache[$md->name] = $md->value;
				}
			}
			return true;
		}
		
		public function get($name) {
			
			if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
				return $this->meta_cache[$name];
			} elseif (array_key_exists($name, $this->meta_defaults)){
				return $this->meta_defaults[$name];
			} 
			
			return parent::get($name);				
		}		
		
		public function setMetaData($name, $value){
			if(parent::setMetaData($name, $value)){
				if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
					$this->meta_cache[$name] = $value;
				}
				return true;
			}
		}
		
		public function clearMetaData($name){
			if(parent::clearMetaData($name)){
				if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
					unset($this->meta_cache[$name]);
				}
				return true;
			}
			return false;
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
		
		public function getHint(){
			// make title
			$hint = $this->metadata_hint;
			
			if(empty($hint)){
				$trans_key = "profile:hint:" . $this->metadata_name;
				if($trans_key != elgg_echo($trans_key)){
					$hint = elgg_echo($trans_key);
				}
			}
			return $hint;
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
 		protected $meta_cache;
 		protected $meta_defaults = array(
 			"metadata_label" => NULL,
 			"metadata_description" => NULL
 			);
 			
		const SUBTYPE = "custom_profile_type";
		
		protected function initialise_attributes() {
			global $CONFIG;
			
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = $CONFIG->site_guid;
			$this->attributes['container_guid'] = $CONFIG->site_guid;
		}
	 
		protected function load($guid) {
			if (!parent::load($guid)) {
				return false;
			}
			
			if($metadata = get_metadata_for_entity($guid)){
				if (!is_array($this->meta_cache)) {
					$this->meta_cache = array();
				}
				foreach($metadata as $md){
					$this->meta_cache[$md->name] = $md->value;
				}
			}
			return true;
		}
		
		public function get($name) {
			if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
				return $this->meta_cache[$name];
			} elseif (array_key_exists($name, $this->meta_defaults)){
				return $this->meta_defaults[$name];
			} 
			
			return parent::get($name);				
		}		
		
		public function setMetaData($name, $value){
			if(parent::setMetaData($name, $value)){
				if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
					$this->meta_cache[$name] = $value;
				}
				return true;
			}
		}
		
		public function clearMetaData($name){
			if(parent::clearMetaData($name)){
				if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
					unset($this->meta_cache[$name]);
				}
				return true;
			}
			return false;
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
 		protected $meta_cache;
 		protected $meta_defaults = array(
 			"metadata_label" => NULL
 			);
 			
		const SUBTYPE = "custom_profile_field_category";
		
		protected function initialise_attributes() {
			global $CONFIG;
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = $CONFIG->site_guid;
			$this->attributes['container_guid'] = $CONFIG->site_guid;
		}
		
		protected function load($guid) {
			if (!parent::load($guid)) {
				return false;
			}
			
			if($metadata = get_metadata_for_entity($guid)){
				if (!is_array($this->meta_cache)) {
					$this->meta_cache = array();
				}
				foreach($metadata as $md){
					$this->meta_cache[$md->name] = $md->value;
				}
			}
			return true;
		}
		
		public function get($name) {
			
			if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
				return $this->meta_cache[$name];
			} elseif (array_key_exists($name, $this->meta_defaults)){
				return $this->meta_defaults[$name];
			} 
			
			return parent::get($name);				
		}		
		
		public function setMetaData($name, $value){
			if(parent::setMetaData($name, $value)){
				if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
					$this->meta_cache[$name] = $value;
				}
				return true;
			}
		}
		
		public function clearMetaData($name){
			if(parent::clearMetaData($name)){
				if(is_array($this->meta_cache) && array_key_exists($name, $this->meta_cache)){
					unset($this->meta_cache[$name]);
				}
				return true;
			}
			return false;
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

<?php
	
	class ProfileManagerCustomProfileType extends ElggObject {
 		protected $meta_cache;
 		protected $meta_defaults = array(
 			"metadata_label" => NULL,
 			"metadata_description" => NULL
 			);
 			
		const SUBTYPE = "custom_profile_type";
		
		protected function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->attributes['subtype'] = self::SUBTYPE;
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
			$this->attributes['container_guid'] = elgg_get_site_entity()->getGUID();
		}
	 
		protected function load($guid) {
			if (!parent::load($guid)) {
				return false;
			}
			
			if($guid instanceof stdClass){
				$guid = $guid->guid;
			}
			
			$metadata_options = array('guid' => $guid, 'limit' => false);
			
			if($metadata = elgg_get_metadata($metadata_options)){
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
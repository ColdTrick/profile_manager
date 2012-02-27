<?php

	abstract class ProfileManagerCustomField extends ElggObject {
 		protected $meta_cache;
 		protected $meta_defaults = array(
 			"admin_only" => "no",
 			"mandatory" => "no", 
 			"show_on_register" => "no", 
 			"output_as_tags" => "no", 
 			"metadata_label" => NULL,
 			"category_guid" => NULL,
 			"metadata_hint" => NULL,
 			"metadata_options" => NULL
 			);
		
		protected function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
			$this->attributes['container_guid'] = elgg_get_site_entity()->getGUID();
		}
	 
		public function __construct($guid = null) {
			parent::__construct($guid);
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
				
				$options = array_combine($options, $options); // add values as labels for deprecated notices
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

<?php

	abstract class ProfileManagerCustomField extends ElggObject {
		
		protected function initializeAttributes() {
			parent::initializeAttributes();
			
			$this->attributes['access_id'] = ACCESS_PUBLIC;
			$this->attributes['owner_guid'] = elgg_get_site_entity()->getGUID();
			$this->attributes['container_guid'] = elgg_get_site_entity()->getGUID();
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

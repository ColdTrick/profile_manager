<?php

namespace ColdTrick\ProfileManager;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function boot() {
		$hooks = $this->elgg()->hooks;
		
		$hooks->registerHandler('route:config', 'action:register', __NAMESPACE__ . '\Routes::addRegisterActionMiddleware');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {

		elgg_define_js('jquery/multiselect', [
			'deps' => [
				'jquery-ui/widget',
				'jquery-ui/data',
			],
			'src' => elgg_get_simplecache_url('jquery/multiselect'),
		]);
	}
}

<?php

namespace ColdTrick\ProfileManager;

use Elgg\DefaultPluginBootstrap;

/**
 * Plugin bootstrap
 */
class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function boot() {
		$this->elgg()->events->registerHandler('route:config', 'action:register', __NAMESPACE__ . '\Routes::addRegisterActionMiddleware');
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

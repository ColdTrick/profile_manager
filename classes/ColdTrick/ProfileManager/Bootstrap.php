<?php

namespace ColdTrick\ProfileManager;

use Elgg\DefaultPluginBootstrap;

/**
 * Plugin bootstrap
 */
class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritdoc}
	 */
	public function boot() {
		$this->elgg()->events->registerHandler('route:config', 'action:register', __NAMESPACE__ . '\Routes::addRegisterActionMiddleware');
	}
}

<?php

namespace ColdTrick\ProfileManager;

class Routes {
	
	/**
	 * Add middleware to the register action
	 *
	 * @param \Elgg\Hook $hook 'route:config', 'action:register'
	 *
	 * @return array
	 */
	public static function addRegisterActionMiddleware(\Elgg\Hook $hook): array {
		
		$params = $hook->getValue();
		
		$middleware = elgg_extract('middleware', $params, []);
		$middleware[] = '\ColdTrick\ProfileManager\Users::validateRegisterAction';
		
		$params['middleware'] = $middleware;
		
		return $params;
	}
}

<?php

namespace ColdTrick\ProfileManager;

/**
 * Route related callbacks
 */
class Routes {
	
	/**
	 * Add middleware to the register action
	 *
	 * @param \Elgg\Event $event 'route:config', 'action:register'
	 *
	 * @return array
	 */
	public static function addRegisterActionMiddleware(\Elgg\Event $event): array {
		
		$params = $event->getValue();
		
		$middleware = elgg_extract('middleware', $params, []);
		$middleware[] = '\ColdTrick\ProfileManager\Users::validateRegisterAction';
		
		$params['middleware'] = $middleware;
		
		return $params;
	}
}

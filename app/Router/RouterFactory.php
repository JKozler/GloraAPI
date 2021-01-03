<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');
		$router->addRoute('teams/<id>', 'Api:default');
		$router->addRoute('users/<id>', 'Api:default');
		$router->addRoute('tasks/<id>', 'Api:default');
		$router->addRoute('tasks/<json>', 'Api:default');
		$router->addRoute('users/<json>', 'Api:default');
		return $router;
	}
}

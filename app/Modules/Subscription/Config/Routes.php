<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('subscription', ['namespace' => 'App\Modules\Subscription\Controllers'], function($subroutes){
	$subroutes->add('', 'Subscription::index');
});
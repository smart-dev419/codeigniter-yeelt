<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('orders', ['namespace' => 'App\Modules\Orders\Controllers'], function($subroutes){
	$subroutes->add('', 'Orders::list');
	$subroutes->add('data/(:any)', 'Orders::data/$1');
});
<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('products', ['namespace' => 'App\Modules\Products\Controllers'], function($subroutes){
	$subroutes->add('', 'Products::list');
});
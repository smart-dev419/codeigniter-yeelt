<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('support', ['namespace' => 'App\Modules\Support\Controllers'], function($subroutes){
	$subroutes->add('', 'Support::index');
});
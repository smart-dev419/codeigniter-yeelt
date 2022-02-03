<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('overview', ['namespace' => 'App\Modules\Overview\Controllers'], function($subroutes){
	$subroutes->add('', 'Overview::index');
	$subroutes->add('(:any)/(:any)', 'Overview::index/$1/$2');
	$subroutes->add('stats', 'Overview::stats');
});
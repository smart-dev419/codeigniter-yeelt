<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('codeflowdemo', ['namespace' => 'App\Modules\Codeflowdemo\Controllers'], function($subroutes){
	$subroutes->add('/', 'Codeflowdemo::index');
	$subroutes->add('out', 'Codeflowdemo::out');
});
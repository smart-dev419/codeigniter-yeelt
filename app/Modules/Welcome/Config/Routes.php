<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('welcome', ['namespace' => 'App\Modules\Welcome\Controllers'], function($subroutes){
	$subroutes->add('', 'Welcome::index');
    //$subroutes->add('LoginRecoveryModel ', 'Welcome::LoginRecoveryModel ');
});
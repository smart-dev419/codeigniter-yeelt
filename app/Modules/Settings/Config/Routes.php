<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('settings', ['namespace' => 'App\Modules\Settings\Controllers'], function($subroutes){
	$subroutes->add('', 'Settings::index');
	$subroutes->add('process_profile', 'Settings::process_profile');

	$subroutes->add('users', 'Settings::users');
	$subroutes->add('logo', 'Settings::logo');
	$subroutes->add('logo_process', 'Settings::logo_process');
	$subroutes->add('users/user_invite', 'Settings::process_invite');
	$subroutes->add('users/delete/(:any)/(:any)', 'Settings::delete/$1/$2');
});
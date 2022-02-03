<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('login', ['namespace' => 'App\Modules\Login\Controllers'], function($subroutes){
	$subroutes->add('/', 'Login::index');
	$subroutes->add('process', 'Login::process');
	$subroutes->add('logout', 'Login::logout');
	$subroutes->add('bolcallback', 'Login::bolcallback');

	$subroutes->add('accept/(:any)/(:any)/(:any)', 'Login::invite/$1/$2/$3/accept');
	$subroutes->add('reject/(:any)/(:any)/(:any)', 'Login::invite/$1/$2/$3/reject');

	$subroutes->add('process_invite', 'Login::process_invite');
	$subroutes->add('switch_seller', 'Login::switch_seller');
	
	//register
	$subroutes->add('register_form', 'Login::register_form');
	$subroutes->add('register_proccess', 'Login::register_proccess');
	$subroutes->add('emailverified/(:any)/(:any)', 'Login::emailverified/$1/$2');

	//Password forgotten
	$subroutes->add('forgot_password', 'Login::forgot_password');
	$subroutes->add('forgotPassword_form', 'Login::forgotPassword_form');
	
	//Password forgotten reovery
	$subroutes->add('recovery', 'Login::recovery');
	$subroutes->add('recovery_process', 'Login::recovery_process');
});
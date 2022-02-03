<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('account', ['namespace' => 'App\Modules\Account\Controllers'], function($subroutes){
	$subroutes->add('', 'Account::account');
	$subroutes->add('process_account', 'Account::process_account');
	$subroutes->add('createSeller_form', 'Account::createSeller_form');
	$subroutes->add('createSeller_process', 'Account::createSeller_process');
	
});
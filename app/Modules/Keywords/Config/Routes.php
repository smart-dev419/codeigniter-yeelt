<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('keywords', ['namespace' => 'App\Modules\Keywords\Controllers'], function($subroutes){
	$subroutes->add('list', 'Keywords::list');
	$subroutes->add('delete/(:any)/(:any)', 'Keywords::delete/$1/$2');
	$subroutes->add('add_suggestion/(:any)/(:any)', 'Keywords::add_suggestion/$1/$2');

	$subroutes->add('suggestions', 'Keywords::suggestions');

	$subroutes->add('add', 'Keywords::add'); // step 1
	$subroutes->add('add_volumes', 'Keywords::volumes'); // step 2
	$subroutes->add('get_volumes', 'Keywords::get_volumes'); // step 2
	$subroutes->add('add_process', 'Keywords::add_process'); // step 2
	$subroutes->add('add_result', 'Keywords::add_result'); // step 2
});
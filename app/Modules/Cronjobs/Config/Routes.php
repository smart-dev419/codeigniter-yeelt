<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('cronjobs', ['namespace' => 'App\Modules\Cronjobs\Controllers'], function($subroutes){

	/*** Route for Dashboard ***/
    $subroutes->add('actions1', 'Cronjobs::actions1');

});
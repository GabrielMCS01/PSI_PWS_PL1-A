<?php
/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 02-05-2016
 * Time: 11:18
 */
use ArmoredCore\Facades\Router;

/****************************************************************************
 *  URLEncoder/HTTPRouter Routing Rules
 *  Use convention: controllerName/methodActionName
 ****************************************************************************/

/*Router::get('/',			'HomeController/index');
Router::get('home/',		'HomeController/index');
Router::get('home/index',	'HomeController/index');
Router::get('home/start',	'HomeController/start');

Router::get('test/index',  'TestController/index');
*/
Router::get('/',  'UserController/index');

Router::resource('users', 'UserController');

Router::resource('airplanes', 'AirplaneController');

Router::resource('airports', 'AirportController');

Router::resource('flights', 'FlightController');

Router::resource('scales', 'ScalesController');

Router::resource('users_flights', 'Users_flightController');

//Página de routing do projeto


/************** End of URLEncoder Routing Rules ************************************/

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
Router::get('/',  'UtilizadoresController/index');

Router::resource('utilizadores', 'UtilizadoresController');

Router::get('avioes/index', 'AvioesController/index');
Router::get('avioes/create', 'AvioesController/create');
Router::post('avioes/store', 'AvioesController/store');
Router::post('avioes/edit', 'AvioesController/edit');










/************** End of URLEncoder Routing Rules ************************************/
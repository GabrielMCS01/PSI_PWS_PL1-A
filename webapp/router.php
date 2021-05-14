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
Router::get('/',  'AutenticacaoController/index');
Router::get('utilizadores/',  'AutenticacaoController/index');
Router::get('utilizadores/index',  'AutenticacaoController/index');
Router::get('utilizadores/create',  'AutenticacaoController/create');
Router::post('utilizadores/show',  'AutenticacaoController/show');

//Router::resource('utilizadores', 'AutenticacaoController');










/************** End of URLEncoder Routing Rules ************************************/
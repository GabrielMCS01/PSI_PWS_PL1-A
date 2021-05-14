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

Router::get('/',			'HomeController/index');
Router::get('home/',		'HomeController/index');
Router::get('home/index',	'HomeController/index');
Router::get('home/start',	'HomeController/start');

Router::get('test/index',  'TestController/index');

Router::get('autenticacao/',  'AutenticacaoController/index');
Router::get('autenticacao/index',  'AutenticacaoController/index');
Router::get('autenticacao/create',  'AutenticacaoController/create');

//Router::resource('autenticacao', 'AutenticacaoController');










/************** End of URLEncoder Routing Rules ************************************/
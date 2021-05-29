<?php
//Configuração do user e das portas do servidor MySql
//Para esse efeito criamos um user no workbench e é a partir desse use "pwa" que o projeto acede à BD
//Configuração da base de dados a ser utilizada
//configurações gerais do servidor
$defaultDbConnection = array (
    'DBMS'          => 'mysql',
    'SERVER'        => 'localhost',
    'PORT'          => '3306',
    'DATABASENAME'  => 'pwsaeroporto',
    'USER'          => 'pwa',
    'PASSWORD'      => 'pwa',
    'CHARSET'       => 'utf8',
    'COLLATION'     => 'utf8_unicode_ci',
);
<?php

use ArmoredCore\Controllers\BaseController;

class TestController extends BaseController
{
//Controlador utilizado somente para testes implementados
    public function index(){

        $tests = Test::all();

        foreach ($tests as $test) {
            echo $test->testtext . '<br>';
        }
    }

}
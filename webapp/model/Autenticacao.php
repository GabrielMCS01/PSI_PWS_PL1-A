<?php

use ActiveRecord\Model;
use ArmoredCore\WebObjects\Data;
use Tracy\Dumper;

class Autenticacao extends Model
{
    public function __construct($login){
        Dumper::dump($login);
    }
}
?>
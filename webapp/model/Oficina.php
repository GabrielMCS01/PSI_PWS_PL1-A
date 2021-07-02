<?php

use ActiveRecord\Model;

class Oficina extends Model{
    //Definição do modelo(objeto)
    static $has_many = [
        ['Airport']
    ];
}
?>
<?php

use ActiveRecord\Model;

class Airplane extends Model{
    //Definição do modelo(objeto)
    // Um "avião" tem vários "voos" e "escalas"
    static $has_many = [['flight'], ['scale']];
}
?>
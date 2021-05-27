<?php

use ActiveRecord\Model;

class Airplane extends Model{
    // Um "avião" tem vários "voos" e "escalas"
    static $has_many = [['flight'], ['scale']];
}
?>
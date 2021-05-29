<?php

use ActiveRecord\Model;

class Airport extends Model{
    //Definição do modelo(objeto)
    // Um "Aeroporto" tem vários "Voos" e "Escalas"
    static $has_many = [
        //Voos
        ['origin_flight', 'foreign_key' =>'origin_airport_id', 'class_name' => 'Flight'],
        ['destination_flight', 'foreign_key' =>'destination_airport_id', 'class_name' => 'Flight'],
        //Escalas
        ['origin_scale', 'foreign_key' =>'originairport_id', 'class_name' => 'Scale'],
        ['destination_scale', 'foreign_key' =>'destinationairport_id', 'class_name' => 'Scale'],
    ];
}
?>
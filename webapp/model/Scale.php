<?php

use ActiveRecord\Model;

class Scale extends Model{
    //Definição do modelo(objeto)
    // Uma "Escala" pertence a um "Avião", "Aeroporto" e a um "Voo"
    static $belongs_to = [
        ['airplane'],
        ['origin_airport', 'foreign_key' => 'originairport_id', 'class_name' => 'Airport'],
        ['destination_airport', 'foreign_key' => 'destinationairport_id', 'class_name' => 'Airport'],
        ['flight']
    ];
}
?>
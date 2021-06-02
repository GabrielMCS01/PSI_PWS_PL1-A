<?php

use ActiveRecord\Model;

class Users_flight extends Model{
    // Definição do modelo(objeto)
    // Uma "Compra de um Voo" pertence a um "Voo" e um "User" (cliente)
    static $belongs_to = [
        ['flight', 'foreign_key' => 'flight_id', 'class_name' => 'Flight'],
        ['flight_back', 'foreign_key' => 'flight_back_id', 'class_name' => 'Flight'],
        ['client', 'foreign_key' => 'client_id', 'class_name' => 'User']
    ];
}
?>
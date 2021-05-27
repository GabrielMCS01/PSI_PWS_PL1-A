<?php

use ActiveRecord\Model;

class Users_flight extends Model{

    // Uma "Compra de um Voo" pertence a um "Voo" e um "User" (cliente)
    static $belongs_to = [
        ['flight'],
        ['flight_back', 'floreign_key' => 'flight_back_id', 'class_name' => 'Flight'],
        ['client', 'floreign_key' => 'client_id', 'class_name' => 'User']
    ];
}
?>
<?php

use ActiveRecord\Model;

class Purchasesflight extends Model{

    // Uma "Compra de um Voo" pertence a um "Voo" e um "User" (cliente)
    static $belongs_to = [
        ['flight'],
        ['client', 'floreign_key' => 'client_id', 'class_name' => 'User']
    ];
}
?>
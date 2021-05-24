<?php

use ActiveRecord\Model;

class Purchasesflight extends Model{

    static $belongs_to = [
        ['flight'],
        ['client', 'floreign_key' => 'client_id', 'class_name' => 'User']
    ];
}
?>
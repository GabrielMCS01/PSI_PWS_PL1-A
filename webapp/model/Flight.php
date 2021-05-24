<?php

use ActiveRecord\Model;

class Flight extends Model{

    static $belongs_to = [
        ['airplane'],
        ['origin_airport', 'foreign_key' =>'origin_airport_id', 'class_name' => 'Airport'],
        ['destination_airport', 'foreign_key' =>'destination_airport_id', 'class_name' => 'Airport']
    ];

    static $has_many = [['scale']];
}
?>
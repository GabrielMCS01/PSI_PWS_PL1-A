<?php

use ActiveRecord\Model;

class Flight extends Model{

    static $belongs_to = [
        ['airplane'],
        ['origin_airport', 'foreign_key' =>'origin_airport_id', 'class_name' => 'Airport'],
        ['destination_airport', 'foreign_key' =>'destination_airport_id', 'class_name' => 'Airport']
    ];

    public function FormatarData($dado){
        return date('d/m/Y H:i', strtotime($dado));
    }
}
?>
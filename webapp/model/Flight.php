<?php

use ActiveRecord\Model;

class Flight extends Model{
    //Definição do modelo(objeto)
    // Um "Voo" pertence a um "Aviao", "Aeroporto de Origem" e a um "Aeroporto de Destino"
    static $belongs_to = [
        ['airplane'],
        ['origin_airport', 'foreign_key' =>'origin_airport_id', 'class_name' => 'Airport'],
        ['destination_airport', 'foreign_key' =>'destination_airport_id', 'class_name' => 'Airport']
    ];

    // Um "Voo" tem várias "Escalas"
    static $has_many = [['scale'],
    ['userflight', 'foreign_key' =>'flight_id', 'class_name' => 'Users_flight']];

}
?>
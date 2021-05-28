<?php

use ActiveRecord\Model;

class Scale extends Model{

    // Uma "Escala" pertence a um "Avião", "Aeroporto" e a um "Voo"
    static $belongs_to = [
        ['airplane'],
        ['airport'],
        ['flight']
    ];
}
?>
<?php

use ActiveRecord\Model;

class Scale extends Model{
    //Definição do modelo(objeto)
    // Uma "Escala" pertence a um "Avião", "Aeroporto" e a um "Voo"
    static $belongs_to = [
        ['airplane'],
        ['airport'],
        ['flight']
    ];
}
?>
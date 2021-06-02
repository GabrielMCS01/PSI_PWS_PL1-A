<?php

use ActiveRecord\Model;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use Tracy\Dumper;

class User extends Model
{
    //Definição do modelo(objeto)
    // Um "User" pode ter várias "Compras de Voos"
    static $has_many = [['userflight', 'foreign_key' =>'client_id', 'class_name' => 'Users_flight']];

    public function TipoUserMostrar($tipouser){
        switch ($tipouser){
            case 'administrador':
                return 'Administrador';
                break;
            case 'gestordevoo':
                return 'Gestor de Voo';
                break;
            case 'operadordecheckin':
                return 'Operador de Checkin';
                break;
            case 'passageiro':
                return 'Passageiro';
                break;
        }
    }
}
?>
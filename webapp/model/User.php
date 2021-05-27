<?php

use ActiveRecord\Model;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use Tracy\Dumper;

class User extends Model
{
    // Um "User" pode ter várias "Compras de Voos"
    static $has_many = [['user_purchasesflight', 'foreign_key' =>'client_id', 'class_name' => 'Users_flight']];
}
?>
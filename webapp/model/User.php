<?php

use ActiveRecord\Model;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use Tracy\Dumper;

class User extends Model
{
    static $has_many = [['user_purchasesflight', 'foreign_key' =>'client_id', 'class_name' => 'Purchasesflight']];
}
?>
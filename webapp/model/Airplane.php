<?php

use ActiveRecord\Model;

class Airplane extends Model{
    static $has_many = [['flight'], ['scale']];
}
?>
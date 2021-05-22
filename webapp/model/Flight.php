<?php

use ActiveRecord\Model;

class Flight extends Model{

    static $belongs_to = [['airplane']];

    public function FormatarData($dado){
        return date('d/m/Y H:i', strtotime($dado));
    }

    public function NomeAeroporto($dado){
        if (isset($dado)) {
            $aeroporto = Airport::find(['airports_id' => $dado]);
        }
        return $aeroporto->nomeaeroporto;
    }

    public function NomeAviao($dado){
        if (isset($dado)) {
            $aviao = Airplane::find(['airplanes_id' => $dado]);
        }
        return $aviao->nomeaviao;
    }
}
?>
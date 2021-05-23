<?php

use ActiveRecord\Model;

class Scale extends Model{

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
            $aviao = Avioes::find(['airplane_id' => $dado]);
        }
        return $aviao->nomeaviao;
    }

    public function Voo($dado){
        if (isset($dado)) {
            $voo = Flight::find(['flights_id' => $dado]);
        }
        return $voo->nomevoo;
    }
}
?>
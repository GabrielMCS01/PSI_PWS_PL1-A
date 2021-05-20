<?php

use ActiveRecord\Model;

class Voos extends Model{

    public function FormatarData($dado){
        return date('d/m/Y H:i', strtotime($dado));
    }

    public function NomeAeroporto($dado){
        if (isset($dado)) {
            $aeroporto = Aeroportos::find(['IdAeroporto' => $dado]);
        }
        return $aeroporto->nomeaeroporto;
    }

    public function NomeAviao($dado){
        if (isset($dado)) {
            $aviao = Avioes::find(['idAviao' => $dado]);
        }
        return $aviao->nomeaviao;
    }
}
?>
<?php

use ActiveRecord\Model;
use ArmoredCore\WebObjects\Data;
use Tracy\Dumper;

class Utilizadores extends Model
{
    /**
     * @throws \ActiveRecord\RecordNotFound
     */
    public function Login($id, $login){
        switch($id) {
            case 'passageiro':
                $utilizadores = Utilizadores::find($login);
                if($utilizadores != null){
                    Dumper::dump("Entrou!");
                    $_SESSION['username'] = $login['Utilizador'];
                    $_SESSION['tipoUser'] = $id;
                }else{
                    Dumper::dump("Não entrou!");
                    session_destroy();
                }
                break;
            default:
                //Dumper::dump("Não é passageiro");
                break;
        }
    }
}
?>
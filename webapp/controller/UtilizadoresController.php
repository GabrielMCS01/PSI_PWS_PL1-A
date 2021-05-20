<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class UtilizadoresController extends BaseController implements ResourceControllerInterface
{
    public function index()
    {
        return View::make('utilizadores.index');
    }

    public function create()
    {
        return View::make('utilizadores.create');
    }

    public function store()
    {
        $dados = [
            'Utilizador' => Post::get('Utilizador'),
            'NomeCompleto' => Post::get('NomeCompleto'),
            'DataNascimento' => Post::get('DataNascimento'),
            'Email' => Post::get('Email'),
            'Telefone' => Post::get('Telefone'),
            'PasswordUtilizador' => Post::get('PasswordUtilizador'),
            'Perfil' => 'passageiro'
            ];
        $utilizador = new Utilizadores($dados);
        $utilizador->save();
        Redirect::toRoute('utilizadores/index');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $utilizador = Utilizadores::find([$id]);
            return View::make('utilizadores.edit', ['utilizador' => [$utilizador]]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function update($id)
    {
        if(isset($_SESSION['username'])) {
            $user = Utilizadores::find([$id]);
            $user->update_attributes(Post::getAll());
            $user->save();
            if($_SESSION['tipoUser'] == 'administrador') {
                Redirect::toRoute('utilizadores/showall');
            }else{
                Redirect::toRoute('utilizadores/perfil', ['id' => $id]);
            }
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            $user = Utilizadores::find([$id]);
            $user->delete();
            Redirect::toRoute('utilizadores/showall');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function showall()
    {
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            $utilizadores = Utilizadores::all();
            return View::make('utilizadores.showall', ['utilizadores' => $utilizadores]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function login($id)
    {
        switch($id) {
            case 'passageiro':
                $utilizadores = Utilizadores::find(Post::getAll());
                if($utilizadores != null){
                    $_SESSION['username'] = Post::get('Utilizador');
                    $_SESSION['tipoUser'] = $utilizadores->perfil;
                    Redirect::toRoute('avioes/index');
                }else{
                    session_unset();
                    $_SERVER['mensagem'] = "Username ou Password incorreto";
                    return View::make('utilizadores.index');
                }
                break;
            default:
                //Dumper::dump("Não é passageiro");
                break;
        }
    }

    public function sair()
    {
        Session::destroy();
        Redirect::toRoute('utilizadores/index');
    }
}
?>
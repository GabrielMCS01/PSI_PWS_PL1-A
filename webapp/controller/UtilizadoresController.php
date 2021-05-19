<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use Carbon\Traits\Date;
use Tracy\Dumper;

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
            /*'DataNascimento' => '2000-01-01',*/
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
        $utilizador = new Utilizadores();
        switch($id) {
            case 'passageiro':
                $utilizadores = Utilizadores::find(Post::getAll());
                if($utilizadores != null){
                    $_SESSION['username'] = Post::get('Utilizador');
                    $_SESSION['tipoUser'] = $id;
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

    public function edit($id)
    {
        // TODO: Implement edit() method.
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
?>
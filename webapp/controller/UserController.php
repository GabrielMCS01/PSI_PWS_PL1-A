<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class UserController extends BaseController implements ResourceControllerInterface
{
    public function index()
    {
        return View::make('users.index');
    }

    public function create()
    {
        return View::make('users.create');
    }

    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        $dados = [
            'username' => Post::get('username'),
            'fullname' => Post::get('fullname'),
            'birthdate' => Post::get('birthdate'),
            'email' => Post::get('email'),
            'phonenumber' => Post::get('phonenumber'),
            'userpassword' => Post::get('userpassword'),
            'userprofile' => 'passageiro'
            ];
        $utilizador = new User($dados);
        $utilizador->save();
        Redirect::toRoute('users/index');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $utilizador = User::first([$id]);
            return View::make('users.edit', ['utilizador' => $utilizador]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $user = User::first([$id]);
            $user->update_attributes(Post::getAll());
            $user->save();
            if($_SESSION['tipoUser'] == 'administrador') {
                Redirect::toRoute('users/showall');
            }else{
                Redirect::toRoute('flights/index');
            }
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            $user = User::first([$id]);
            $user->delete();
            Redirect::toRoute('users/showall');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function showall()
    {
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            $utilizadores = User::all();
            return View::make('users.showall', ['users' => $utilizadores, 'searchbar' => '']);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function login($id)
    {
        if($id == 'logged') {
            $utilizadores = User::first(Post::getAll());
            if ($utilizadores != null) {
                $_SESSION['username'] = Post::get('username');
                $_SESSION['userid'] = $utilizadores->users_id;
                $_SESSION['tipoUser'] = $utilizadores->userprofile;
                switch ($_SESSION['tipoUser']) {
                    case "passageiro":
                        Redirect::toRoute('flights/index');
                        break;
                    case "administrador":
                        Redirect::toRoute('airports/index');
                        break;
                }
            } else {
                session_unset();
                $_SERVER['mensagem'] = "Username ou Password incorreto";
                return View::make('users.index');
            }
        }else{
            session_unset();
            $_SERVER['mensagem'] = "Username ou Password incorreto";
            return View::make('users.index');
        }
    }

    public function search()
    {
        $searching = Post::get('search');

        $search = User::find('all', array('conditions' =>
            "fullname LIKE '%$searching%' OR 
            birthdate LIKE '%$searching%' OR
            email LIKE '%$searching%' OR 
            phonenumber LIKE '%$searching%' OR
            username LIKE '%$searching%' OR
            userprofile LIKE '%$searching%'
            "));

        return View::make('users.showall', ['users' => $search, 'searchbar' => $searching]);
    }

    public function sair()
    {
        Session::destroy();
        Redirect::toRoute('users/index');
    }
}
?>
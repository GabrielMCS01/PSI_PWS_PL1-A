<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class UserController extends BaseController implements ResourceControllerInterface
{
    //Função que retorna a página index do user(Login)
    public function index()
    {
        // Encripta a password do administrador a primeira vez que abre o programa
        $numeroUsers = User::count();
        if($numeroUsers == 1){
            $user = User::first();
            if($user->userpassword == 'adminmaster') {
                $hash = password_hash($user->userpassword,
                    PASSWORD_DEFAULT);
                $user->update_attributes(['userpassword' => $hash]);
                $user->save();
            }
        }
        return View::make('users.index');
    }

    //Função que retorna a página create do user(registo)
    public function create()
    {
        return View::make('users.create');
    }

    //Função que armazena e grava os dados do utilizador após o seu registo
    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        $hash = password_hash(Post::get('userpassword'),
            PASSWORD_DEFAULT);
        $dados = [
            'username' => Post::get('username'),
            'fullname' => Post::get('fullname'),
            'birthdate' => Post::get('birthdate'),
            'email' => Post::get('email'),
            'phonenumber' => Post::get('phonenumber'),
            'userpassword' => $hash,
            'userprofile' => 'passageiro'
            ];
        $utilizador = new User($dados);
        $utilizador->save();
        //No fim da inserção dos dados, o utilizador será redirecionado para a página de Login(users/index)
        Redirect::toRoute('users/index');
    }

    //Função que permite mostrar o user (ainda não implementada)
    public function show($id)
    {

    }

    //Função que permite a edição dos utilizador
    public function edit($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $utilizador = User::first([$id]);
            return View::make('users.edit', ['utilizador' => $utilizador]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função disponivel somente para administradores, que permite a visualização e atualização
    //de todos os users registados na base de dados
    public function update($id)
    {
        // Se tiver sessão iniciada corre a função
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $user = User::first([$id]);
            $user->update_attributes(Post::getAll());
            $user->save();
            //Se o tipo de user for administrador mostra a lista de utilizadores
            if($_SESSION['tipoUser'] == 'administrador') {
                Redirect::toRoute('users/showall');
            }else{
                //Caso contrário devolve a página de voos
                Redirect::toRoute('flights/index');
            }
        }
    }

    //Função que permite apagar um utilizador escolhido pelo administrador
    public function destroy($id)
    {
        // Se tiver sessão iniciada e o user for administrador faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            //Procurar o objeto user a ser apgado
            $user = User::first([$id]);
            //Apaga o user selecionado(apaga o registo na base de dados)
            $user->delete();
            //Volta à view de mostrar todos os utilizadores registados(todos os registos da base de dados na tabelas users)
            Redirect::toRoute('users/showall');
        }else{
            //se não houver utilizador com login ou se o tipo de utilizador não for administrador
            //Retorna a view de login
            Redirect::toRoute('users/index');
        }
    }

    // Função que mostra todos os utilizadores registados na base de dados(registos da tabela users)
    public function showall()
    {
        // Se tiver sessão iniciada e o user for administrador faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] == 'administrador') {
            $utilizadores = User::all();
            // Volta à view de mostrar todos os utilizadores registados(todos os registos da base de dados na tabelas users)
            return View::make('users.showall', ['users' => $utilizadores, 'searchbar' => '']);
        }else{
            // se não houver utilizador com login ou se o tipo de utilizador não for administrador
            // Retorna a view de login
            Redirect::toRoute('users/index');
        }
    }

    // Função de login
    public function login($id)
    {
        if($id == 'logged') {
            // Pesquisa se existe um utilizador com este nome
            $utilizadores = User::first(['username' => Post::get('username')]);
            if ($utilizadores != null) {

                // Verifica se a password inserida corresponde com a password da base de dados
                $verify = password_verify(Post::get('userpassword'), $utilizadores->userpassword);

                if ($verify) {
                    // Armazenar o nome do utilizador, o id e o seu tipo perfil(admin/passageiro...etc) em varivaeis super globais(Session)
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
                        case "gestordevoo":
                            Redirect::toRoute('flights/index');
                            break;
                        case "operadordecheckin":
                            Redirect::toRoute('users_flights/index');
                            break;
                    }
                } else {
                    session_unset();
                    $_SERVER['mensagem'] = "Username ou Password incorreto";
                    return View::make('users.index');
                }
            } else {
                session_unset();
                $_SERVER['mensagem'] = "Username ou Password incorreto";
                return View::make('users.index');
            }
        }
    }

    //Função que permite procurar um utilizador através da barra de pesquina do formulário
    //Esta função procura por todos os campos da tabela users
    public function search()
    {
        $searching = Post::get('search');

        //Pode-se pesquisar pelo nome, data de nascimento, email etc,
        //Para esse efeito utilizou-se o comando Like e o comando OR para
        //Permitir utilizar todos os campos da tabelas users para pesquisa
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

    //Função que termina a sessão,
    //Destroi as sessões e retorna a página de login
    public function sair()
    {
        Session::destroy();
        Redirect::toRoute('users/index');
    }
}
?>
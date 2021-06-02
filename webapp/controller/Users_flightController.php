<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class Users_flightController extends BaseController implements ResourceControllerInterface{
    // Função que permite visualizar todos os bilhetes do passageiro
    public function index()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if (isset($_SESSION['username'])) {
            $bilhetes = Users_flight::all(['client_id'=>$_SESSION['userid']]);

            // Retorna a View com a variável com todos os aviões(array)
            return View::make('users_flights.index', ['users_flights' => $bilhetes,'searchbar' => '']);
        } else {
            Redirect::toRoute('users/index');
        }
    }

    // Função que permite comprar bilhetes ao passageiro
    // Passar o ID do voo?
    public function create()
    {

    }

    public function createPurchase($id)
    {
        // Se não houver utilizador com login feito, retorna a view de login
        if(isset($_SESSION['username'])) {
            // Retorna o voo selecionado e o user com login feito
            $user = User::first($_SESSION['userid']);
            $voo = Flight::first($id);

            return View::make('users_flights.create', ['user' => $user, 'voo' => $voo]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que permite Guardar os bilhetes do passageiro
    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe os dados do form
            $dadosBilhete = Post::getAll();

            $bilhete = ['client_id'=>$dadosBilhete['client_id']];
            $bilhete += ['flight_id'=>$dadosBilhete['flight_id']];
            if ($dadosBilhete['flight_back_id'] != null) {
                $bilhete += ['flight_back_id'=>$dadosBilhete['flight_back_id']];
            }
            $bilhete += ['price'=>$dadosBilhete['price']];

            // Pesquisar um lugar de avião disponivel
            do {
                $voo = Users_flight::first(['flight_id' => $dadosBilhete['flight_id'], 'planeplace'=>$dadosBilhete['planeplace']]);
                if ($voo != null){
                    $dadosBilhete['planeplace'] = rand(1, $voo->airplane->capacity);
                }
            }while($voo != null);
            $bilhete += ['planeplace'=>$dadosBilhete['planeplace']];

            // Recebe as horas em que o utilizador compra o bilhete
            $bilhete += ['purchasedate'=>date("d-m-Y H:i")];

            $bilheteFinal = new Users_flight($bilhete);

            // Guarda o bilhete
            $bilheteFinal->save();

            Redirect::toRoute('users_flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que mostra um bilhete comprado pelo passageiro em detalhe
    public function show($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $compra = Users_flight::first($id);

            return View::make('users_flights.show', ['compra' => $compra]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que permite editar um bilhete comprado pelo passageiro
    public function edit($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            $compra = Users_flight::first($id);

            return View::make('users_flights.edit', ['compra' => [$compra]]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que permite atualizar os bilhetes que o utilizador passageiro comprou
    public function update($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            // Atualizar a compra
            $compra = Users_flight::first($id);
            $compra->update_attributes(Post::getAll());
            $compra->save();
            Redirect::toRoute('users_flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que elimina a compra que o utilizador comprou
    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username']) && $_SESSION['tipoUser'] != 'passageiro') {
            // Recebe o ID da compra para a poder eliminar e redireciona para o index
            $compra = Users_flight::first($id);
            $compra->delete();

            Redirect::toRoute('users_flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
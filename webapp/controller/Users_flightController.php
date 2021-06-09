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
            // Caso o utilizador seja passageiro carrega apenas as suas compras
            if ($_SESSION['tipoUser'] == 'passageiro') {
                $bilhetes = Users_flight::all(['order' => 'flight_id asc, purchasedate asc'], ['client_id'=>$_SESSION['userid']]);
            }
            // Para os restantes utilizadores são carregados
            else{
                $bilhetes = Users_flight::all(['order' => 'flight_id asc, purchasedate asc']);
            }

            // Retorna a View com a variável com todos os aviões(array)
            return View::make('users_flights.index', ['users_flights' => $bilhetes, 'searchbar' => '']);
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
            // Caso o utilizador seja passageiro, atribui o voo automaticamente ao utilizador
            if ($_SESSION['tipoUser'] == 'passageiro') {
                // Retorna o voo selecionado e o user com login feito
                $user = User::first($_SESSION['userid']);
                $voo = Flight::first($id);
            }

            // Pesquisar um lugar de avião disponivel
            do {
                $lugar = rand(1, $voo->airplane->capacity);
                $usersentado = Users_flight::first(['flight_id' => $voo->flights_id, 'planeplace' => $lugar]);
                if ($usersentado != null){
                    $lugar = rand(1, $voo->airplane->capacity);
                }
            }while($usersentado != null);

            // Pesquisa os voos de volta que tenham data superior à data de partida
            $voosvolta = Flight::all(['conditions' =>
                ['datehourdeparture > ? AND origin_airport_id = ? AND destination_airport_id = ?', $voo->datehourarrival,
                    $voo->destination_airport_id, $voo->origin_airport_id]]);

            return View::make('users_flights.create', ['user' => $user, 'voo' => $voo, 'lugar' => $lugar, 'voosvolta' => $voosvolta]);
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
            if (isset($dadosBilhete['checkbutton'])) {
                $bilhete += ['flight_back_id'=>$dadosBilhete['flight_back_id']];
            }
            $bilhete += ['price'=>$dadosBilhete['price']];

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

    // Função que mostra a compra para se fazer a impressão do bilhete
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
            $userflight = Users_flight::first($id);

            return View::make('users_flights.edit', ['userflight' => $userflight]);
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
            // A variável recebe os dados do form
            $checkin = Post::get('checkin');
            $compra = Users_flight::first([$id]);

            $compra->update_attribute('checkin', $checkin);

            // Guarda o bilhete
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

    public function search()
    {
        // Se tiver sessão iniciada, faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // Recebe o que estava escrito na Pesquisa
            $searching = Post::get('search');

            // Procura pelo aeroporto e pelo avião pesquisado
            $voo = Flight::first(['flightname' => $searching]);
            $vooid = (isset($voo)? $voo->flights_id : '');
            $passageiro = User::first(['fullname' => $searching]);
            $passageiroid = (isset($passageiro)? $passageiro->users_id: '');

            // Pesquisa todos por
            $search = Users_flight::find('all', ['conditions' =>
                "flight_id = '$vooid' OR 
                flight_back_id = '$vooid' OR
                client_id = '$passageiroid' OR
                purchasedate LIKE '%$searching%' OR
                planeplace LIKE '%$searching%' OR
                price LIKE '%$searching%'
                ", 'order' => 'flight_id asc, purchasedate asc']);

            // Retorna a View com os argumentos de procura
            return View::make('users_flights.index', ['users_flights' => $search, 'searchbar' => $searching]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function showflight($id){
        if(isset($_SESSION['username'])) {
            $bilhete = Users_flight::first(['users_flights_id' => $id]);

            $voos = Flight::all(['conditions' => "flights_id = '$bilhete->flight_id' OR flights_id = '$bilhete->flight_back_id'", 'order' => 'datehourdeparture asc']);

            $paises = new Airport();
            $paises = $paises->ListarPaises();

            return View::make('flights.index', ['voos' => $voos, 'searchbar' => '', 'paises' => $paises]);
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>

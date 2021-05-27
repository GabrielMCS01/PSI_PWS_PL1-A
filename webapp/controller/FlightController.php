<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class FlightController extends BaseController implements ResourceControllerInterface{

    // Função que retorna a View para visualizar todos os Voos
    public function index()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe todos os Voos existentes
            $voos = Flight::all();

            // Retorna a View com a variável com todos os Voos
            return View::make('flights.index', ['voos' => $voos, 'searchbar' => '']);
        }else{
            Redirect::toRoute('flights/index');
        }
    }

    // Função que retorna a View para Criar um Voo
    public function create()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // Recebe da Base de Dados todos os "Aeroportos" e "Aviões"
            $aeroportos = Airport::all();
            $avioes = Airplane::all();

            // Retorna a View com o formulário para o Utilizador preencher com os dados do Voo
            // Os "Aeroportos" e "Aviões" também são enviados para o Formulário
            return View::make('flights.create', ['airports' => $aeroportos, 'airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    // Função que cria o Voo e guarda-o na Base de dados
    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe os dados que foram enviados do formulário para criar o Voo
            $voo = Post::getAll();

            // Cria um novo Voo com os dados que foram colocados na variável
            $voos = new Flight($voo);

            // Guarda o Voo na Base de Dados
            $voos->save();

            // Redireciona o Utilizador para a View de Visualização de todos os Voos
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    // Função que retorna a View para editar um Voo
    public function edit($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe os atributos do Voo com o ID que foi selecionado para ser editado
            $voo = Flight::first([$id]);

            // Recebe da Base de Dados todos os "Aeroportos" e "Aviões"
            $aeroportos = Airport::all();
            $avioes = Airplane::all();

            // Retorna a View para editar o Voo, com os dados do Voo selecionado
            // Os "Aeroportos" e "Aviões" também são enviados para o Formulário
            return View::make('flights.edit', ['voo' => $voo, 'airports' => $aeroportos, 'airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $voo = Flight::first([$id]);
            $voo->update_attributes(Post::getAll());
            $voo->save();
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $voo = Flight::first([$id]);
            $voo->delete();
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function search()
    {
        $searching = Post::get('search');

        $airport = Airport::first(['airportname' => $searching]);
        $airportid = (isset($airport))?$airport->airports_id:'';
        $aviao = Airplane::first(['airplanename' => $searching]);
        $aviaoid = (isset($aviao))?$aviao->airplanes_id:'';

        $search = Flight::find('all', array('conditions' =>
            "flightname LIKE '%$searching%' OR 
            datehourdeparture LIKE '%$searching%' OR
            datehourarrival LIKE '%$searching%' OR 
            origin_airport_id = '$airportid' OR
            destination_airport_id = '$airportid' OR
            airplane_id = '$aviaoid' OR
            price LIKE '%$searching%'
            "));
        return View::make('flights.index', ['voos' => $search, 'searchbar' => $searching]);
    }
}
?>
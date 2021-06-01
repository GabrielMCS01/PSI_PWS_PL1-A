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
            Redirect::toRoute('users/index');
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

            // Calcular a distancia dos aeroportos
            $aeroporto = new Airport();
            $origin_name = $aeroporto::first(Post::get('origin_airport_id'))->country;
            $destination_name = $aeroporto::first(Post::get('destination_airport_id'))->country;

            $distancia = $aeroporto->DevolverDistancia($origin_name, $destination_name);
            $voo += ['distance' => $distancia];

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

    // Função que recebe e atualiza os dados do Voo editado na View edit
    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // Recebe os dados do ID do Voo que irá ser atualizado
            $voo = Flight::first([$id]);

            $vooupdated = Post::getAll();

            $aeroporto = new Airport();
            $origin_name = $aeroporto::first(Post::get('origin_airport_id'))->country;
            $destination_name = $aeroporto::first(Post::get('destination_airport_id'))->country;

            $distancia = $aeroporto->DevolverDistancia($origin_name, $destination_name);
            $vooupdated += ['distance' => $distancia];

            // atribui os valores que são recebidos do formulário, preenche-os na variável e guarda na Base de dados
            $voo->update_attributes($vooupdated);
            $voo->save();

            // Retorna a View para se visualizar todos os Voos
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            // A variável recebe os atributos do Voo com o ID selecionado
            $voo = Flight::first([$id]);

            // Se o Voo não tiver escalas associadas faz
            if($voo->scale == null) {
                $voo->delete();
            }else{ // Caso contrário manda uma mensagem de erro
                $_SESSION['mensagemErro'] = "Não foi possivel eliminar o voo porque tem escalas associadas.";
            }

            // Redireciona o utilizador para a View que visualiza todos os Voos
            Redirect::toRoute('flights/index');
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

            // ???
            $airport = Airport::first(['airportname' => $searching]);
            $airportid = (isset($airport)) ? $airport->airports_id : '';
            $aviao = Airplane::first(['airplanename' => $searching]);
            $aviaoid = (isset($aviao)) ? $aviao->airplanes_id : '';

            // Pesquisa todos por
            $search = Flight::find('all', array('conditions' =>
                "flightname LIKE '%$searching%' OR 
            datehourdeparture LIKE '%$searching%' OR
            datehourarrival LIKE '%$searching%' OR 
            origin_airport_id = '$airportid' OR
            destination_airport_id = '$airportid' OR
            airplane_id = '$aviaoid' OR
            price LIKE '%$searching%'
            "));

            // Retorna a View com os argumentos de procura
            return View::make('flights.index', ['voos' => $search, 'searchbar' => $searching]);
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class ScalesController extends BaseController implements ResourceControllerInterface{

    // Função que retorna a View para visualizar todas as escalas
    public function index()
    {
        // Se tiver sessão inciada retorna todas as escalas, caso contrário redireciona para a página escalas
        if(isset($_SESSION['username']) ) {
            $escalas = Scale::all();
            return View::make('scales.index', ['scales' => $escalas]);
        }else{
            Redirect::toRoute('scales/index');
        }
    }

    //Função que retorna a view create das escalas
    public function create()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $aeroportos = Airport::all();
            $avioes = Airplane::all();
            $voos = Flight::all();
            return View::make('scales.create', ['airports' => $aeroportos, 'airplanes' => $avioes, 'flights' => $voos]);
        }else{
            Redirect::toRoute('users/index');
        }
    }


    //Função que faz a inserçãp de dados das escalas na base de dados
    public function store()
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        //Utilização do active record para fazer a inserção de dados
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Post::getAll();
            $escalas = new Scale($escala);
            $escalas->save();
            Redirect::toRoute('scales/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função que mostra uma escala consoante a escala escolhida através do seu ID
    // Este id corresponde ao id do voo
    public function show($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
             $escalas = Scale::all(['flight_id' => $id]);
             $voo = Flight::first($id);
             return View::make('scales.index', ['scales' => $escalas, 'voo' => $voo]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função que edita uma escala escolhida através do seu ID
    public function edit($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $escala = Scale::first([$id]);
            $aeroportos = Airport::all();
            return View::make('scales.edit', ['escala' => $escala, 'airports' => [$aeroportos]]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função que permite ao user atualizar dados de uma dada escala
    public function update($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Scale::first([$id]);

            // Calcular a distancia dos aeroportos
            $aeroporto = new Airport();
            $origin_name = $aeroporto::first(Post::get('origin_airport_id'))->country;
            $destination_name = $aeroporto::first(Post::get('destination_airport_id'))->country;

            $distancia = $aeroporto->DevolverDistancia($origin_name, $destination_name);
            $escala += ['distance' => $distancia];

            $escala->update_attributes(Post::getAll());
            $escala->save();
            Redirect::toRoute('scales/show/'.$id);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função que apaga uma dada escala escolhida pelo user
    public function destroy($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $escala = Scale::first([$id]);
            $escala->delete();
            Redirect::toRoute('scales/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função que permite criar uma escala através de um voo
    public function createfromvoo($id)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        if(isset($_SESSION['username'])) {
            $aeroportos = Airport::all();
            $avioes = Airplane::all();
            $flights = Flight::first($id);
            return View::make('scales.create', ['airports' => $aeroportos, 'airplanes' => $avioes, 'flights' => $flights]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    //Função que armazena a escala associada a um voo da base de dados
    public function storefromvoo($vooid)
    {
        // Se tiver sessão iniciada faz caso contrário é redirecionado para a página de Login
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Post::getAll();
            $escala['flight_id'] = $vooid;

            // Calcular a distancia dos aeroportos
            $aeroporto = new Airport();
            $origin_name = $aeroporto::first(Post::get('originairport_id'))->country;
            $destination_name = $aeroporto::first(Post::get('destinationairport_id'))->country;

            $distancia = $aeroporto->DevolverDistancia($origin_name, $destination_name);
            $escala += ['distance' => $distancia];

            // Guardar escala
            $escalas = new Scale($escala);
            $escalas->save();
            Redirect::toRoute('scales/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
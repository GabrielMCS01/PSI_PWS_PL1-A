<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class FlightController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $voos = Flight::first();
            \Tracy\Dumper::dump($voos->airport);
            /*$voosModel = new Flight();
            $voosMostrar = [];
            foreach ($flights as $dados){
                $voosMostrarr = [
                    'id' => $dados->idvoo,
                    'nomevoo' => $dados->nomevoo,
                    'datahorapartida' => $voosModel->FormatarData($dados->datahorapartida),
                    'datahorachegada' => $voosModel->FormatarData($dados->datahorachegada),
                    'aeroportoorigem' => $voosModel->NomeAeroporto($dados->idaeroportoorigem),
                    'aeroportodestino' => $voosModel->NomeAeroporto($dados->idaeroportodestino),
                    'aviao' => $voosModel->NomeAviao($dados->idaviao),
                    'preco' => $dados->preco
                ];
                array_push($voosMostrar, $voosMostrarr);
            }
            return View::make('flights.index', ['flights' => $voosMostrar]);
        }else{
            Redirect::toRoute('flights/index');
        */}
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            $aeroportos = Airport::all();
            $avioes = Airplane::all();
            return View::make('flights.create', ['airports' => $aeroportos, 'airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $voo = Post::getAll();
            $voos = new Flight($voo);
            $voos->save();
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $voo = Flight::first([$id]);
            $aeroportos = Airport::all();
            return View::make('flights.edit', ['voo' => [$voo], 'airports' => [$aeroportos]]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
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
        if(isset($_SESSION['username'])) {
            $voo = Flight::first([$id]);
            $voo->delete();
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
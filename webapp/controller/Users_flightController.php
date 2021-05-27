<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class Users_flightController extends BaseController implements ResourceControllerInterface{

    public function index()
    {

    }

    public function create()
    {
        if(isset($_SESSION['username'])) {

            $aeroportos = Airport::all();
            $avioes = Avioes::all();
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
        if(isset($_SESSION['username'])) {
            $compra = Usersflight::first([$id]);

            return View::make('users_flights.show', ['compra' => $compra]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $compra = Usersflight::first([$id]);

            $aeroportos = Airport::all();
            return View::make('users_flights.edit', ['compra' => [$compra], 'airports' => [$aeroportos]]);
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
            Redirect::toRoute('users_flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            // Recebe o ID da compra para a poder eliminar e redireciona para o index
            $compra = Airport::first([$id]);
            $compra->delete();

            Redirect::toRoute('users_flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
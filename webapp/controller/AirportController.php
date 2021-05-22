<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AirportController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $aeroportos = Airport::all();
            return View::make('airports.index', ['airports' => $aeroportos]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            return View::make('airports.create');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function store()
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Post::getAll();
            $aeroportos = new Airport($aeroporto);
            $aeroportos->save();
            Redirect::toRoute('airports/index');
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
            $aeroporto = Airport::first([$id]);
            return View::make('airports.edit', ['aeroporto' => [$aeroporto]]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Airport::first([$id]);
            $aeroporto->update_attributes(Post::getAll());
            $aeroporto->save();
            Redirect::toRoute('airports/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Airport::first([$id]);
            $aeroporto->delete();
            Redirect::toRoute('airports/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
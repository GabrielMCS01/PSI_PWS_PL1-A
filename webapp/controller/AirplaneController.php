<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AirplaneController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $avioes = Airplane::all();
            return View::make('airplanes.index', ['airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            return View::make('airplanes.create');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function store()
    {
        if(isset($_SESSION['username'])) {
            $aviao = Post::getAll();
            $avioes = new Airplane($aviao);
            $avioes->save();
            Redirect::toRoute('airplanes/index');
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
            $aviao = Airplane::first([$id]);
            return View::make('airplanes.edit', ['airplane' => [$aviao]]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        if(isset($_SESSION['username'])) {
            $aviao = Airplane::first([$id]);
            $aviao->update_attributes(Post::getAll());
            $aviao->save();
            Redirect::toRoute('airplanes/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $aviao = Airplane::first([$id]);
            $aviao->delete();
            Redirect::toRoute('airplanes/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
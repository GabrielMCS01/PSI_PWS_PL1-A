<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AeroportosController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $aeroportos = Aeroportos::all();
            return View::make('aeroportos.index', ['aeroportos' => $aeroportos]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            return View::make('aeroportos.create');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function store()
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Post::getAll();
            $aeroportos = new Aeroportos($aeroporto);
            $aeroportos->save();
            Redirect::toRoute('aeroportos/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Aeroportos::find([$id]);
            return View::make('aeroportos.edit', ['aeroporto' => [$aeroporto]]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function update($id)
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Aeroportos::find([$id]);
            $aeroporto->update_attributes(Post::getAll());
            $aeroporto->save();
            Redirect::toRoute('aeroportos/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $aeroporto = Aeroportos::find([$id]);
            $aeroporto->delete();
            Redirect::toRoute('aeroportos/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }
}
?>
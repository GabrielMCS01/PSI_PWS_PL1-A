<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AvioesController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $avioes = Avioes::all();
            return View::make('avioes.index', ['avioes' => $avioes]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            return View::make('avioes.create');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function store()
    {
        if(isset($_SESSION['username'])) {
            $aviao = Post::getAll();
            $avioes = new Avioes($aviao);
            $avioes->save();
            Redirect::toRoute('avioes/index');
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
            $aviao = Avioes::find([$id]);
            return View::make('avioes.edit', ['aviao' => [$aviao]]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function update($id)
    {
        if(isset($_SESSION['username'])) {
            $aviao = Avioes::find([$id]);
            $aviao->update_attributes(Post::getAll());
            $aviao->save();
            Redirect::toRoute('avioes/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $aviao = Avioes::find([$id]);
            $aviao->delete();
            Redirect::toRoute('avioes/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }
}
?>
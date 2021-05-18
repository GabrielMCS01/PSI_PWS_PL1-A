<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;

class AvioesController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        $avioes = Avioes::all();
        return View::make('avioes.index', ['avioes' => $avioes]);
    }

    public function create()
    {
        return View::make('avioes.create');
    }

    public function store()
    {
        $aviao = Post::getAll();
        $avioes = new Avioes($aviao);
        $avioes->save();
        $avioes = Avioes::all();
        return View::make('avioes.index', ['avioes' => $avioes]);

    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        return View::make('avioes.edit', $id);
    }

    public function update($id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
?>
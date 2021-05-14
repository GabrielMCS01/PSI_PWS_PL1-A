<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;
use Tracy\Dumper;

class AutenticacaoController extends BaseController implements ResourceControllerInterface
{
    public function index()
    {
        return View::make('utilizadores.index');
    }

    public function create()
    {
        return View::make('utilizadores.create');
    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        $autenticacao = new Autenticacao(Post::getAll());
    }

    public function edit($id)
    {
        // TODO: Implement edit() method.
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
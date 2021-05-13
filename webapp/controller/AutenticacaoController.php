<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\View;

class AutenticacaoController extends BaseController implements ResourceControllerInterface
{
    public function index()
    {
        return View::make('autenticacao.index');
    }

    public function create()
    {
        return View::make('autenticacao.create');
    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
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
<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class ComprasVooController extends BaseController implements ResourceControllerInterface{

    public function index()
    {

    }

    public function create()
    {
        if(isset($_SESSION['username'])) {

            $aeroportos = Aeroportos::all();
            $avioes = Avioes::all();
            return View::make('voos.create', ['aeroportos' => $aeroportos, 'avioes' => $avioes]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $voo = Post::getAll();
            $voos = new Voos($voo);
            $voos->save();
            Redirect::toRoute('voos/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function show($id)
    {
        if(isset($_SESSION['username'])) {
            $compra = ComprasVoo::first(['IdCompraVoo' => $id]);

            return View::make('comprasvoo.show', ['compra' => $compra]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $compra = ComprasVoo::first(['IdCompraVoo' => $id]);

            $aeroportos = Aeroportos::all();
            return View::make('comprasvoo.edit', ['compra' => [$compra], 'aeroportos' => [$aeroportos]]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $voo = Voos::first([$id]);
            $voo->update_attributes(Post::getAll());
            $voo->save();
            Redirect::toRoute('comprasvoo/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            // Recebe o ID da compra para a poder eliminar e redireciona para o index
            $compra = Aeroportos::first([$id]);
            $compra->delete();

            Redirect::toRoute('comprasvoo/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }
}
?>
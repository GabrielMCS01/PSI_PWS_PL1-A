<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class VoosController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $voos = Voos::all();
            $voosModel = new Voos();
            $voosMostrar = [];
            foreach ($voos as $dados){
                $voosMostrarr = [
                    'id' => $dados->idvoo,
                    'datahorapartida' => $voosModel->FormatarData($dados->datahorapartida),
                    'datahorachegada' => $voosModel->FormatarData($dados->datahorachegada),
                    'aeroportoorigem' => $voosModel->NomeAeroporto($dados->idaeroportoorigem),
                    'aeroportodestino' => $voosModel->NomeAeroporto($dados->idaeroportodestino),
                    'aviao' => $voosModel->NomeAviao($dados->idaviao)
                ];
                array_push($voosMostrar, $voosMostrarr);
            }
            return View::make('voos.index', ['voos' => $voosMostrar]);
        }else{
            Redirect::toRoute('voos/index');
        }
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
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        if(isset($_SESSION['username'])) {
            $voo = Voos::find([$id]);
            $aeroportos = Aeroportos::all();
            return View::make('voos.edit', ['voo' => [$voo], 'aeroportos' => [$aeroportos]]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $voo = Voos::find([$id]);
            $voo->update_attributes(Post::getAll());
            $voo->save();
            Redirect::toRoute('voos/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $voo = Aeroportos::find([$id]);
            $voo->delete();
            Redirect::toRoute('voos/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }
}
?>
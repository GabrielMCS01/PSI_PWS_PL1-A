<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class EscalasController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $escalas = Escalas::all();
            $escalasModel = new Escalas();
            $escalasMostrar = [];
            foreach ($escalas as $dados){
                $escalasMostrarr = [
                    'id' => $dados->idescala,
                    'datahorapartida' => $escalasModel->FormatarData($dados->datahorapartida),
                    'datahorachegada' => $escalasModel->FormatarData($dados->datahorachegada),
                    'aeroportoorigem' => $escalasModel->NomeAeroporto($dados->idaeroportoorigem),
                    'aeroportodestino' => $escalasModel->NomeAeroporto($dados->idaeroportodestino),
                    'aviao' => $escalasModel->NomeAviao($dados->idaviao),
                    'voo' => $escalasModel->Voo($dados->idvoo)
                ];
                array_push($escalasMostrar, $escalasMostrarr);
            }
            return View::make('escalas.index', ['escalas' => $escalasMostrar]);
        }else{
            Redirect::toRoute('escalas/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            $aeroportos = Aeroportos::all();
            $avioes = Avioes::all();
            $voos = Voos::all();
            return View::make('escalas.create', ['aeroportos' => $aeroportos, 'avioes' => $avioes, 'voos' => $voos]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Post::getAll();
            $escalas = new Escalas($escala);
            $escalas->save();
            Redirect::toRoute('escalas/index');
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
            $escala = Escalas::first([$id]);
            $aeroportos = Aeroportos::all();
            return View::make('escalas.edit', ['escala' => [$escala], 'aeroportos' => [$aeroportos]]);
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Escalas::first([$id]);
            $escala->update_attributes(Post::getAll());
            $escala->save();
            Redirect::toRoute('escalas/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $escala = Aeroportos::first([$id]);
            $escala->delete();
            Redirect::toRoute('escalas/index');
        }else{
            Redirect::toRoute('utilizadores/index');
        }
    }
}
?>
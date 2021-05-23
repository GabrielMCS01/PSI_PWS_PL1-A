<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class ScalesController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $escalas = Scale::all();
            $escalasModel = new Scale();
            $escalasMostrar = [];
            foreach ($escalas as $dados){
                $escalasMostrarr = [
                    'id' => $dados->idescala,
                    'nomevoo' =>  $dados->nomevoo,
                    'datahorapartida' => $escalasModel->FormatarData($dados->datahorapartida),
                    'datahorachegada' => $escalasModel->FormatarData($dados->datahorachegada),
                    'aeroportoorigem' => $escalasModel->NomeAeroporto($dados->idaeroportoorigem),
                    'aeroportodestino' => $escalasModel->NomeAeroporto($dados->idaeroportodestino),
                    'aviao' => $escalasModel->NomeAviao($dados->idaviao),
                    'voo' => $escalasModel->Voo($dados->idvoo)
                ];
                array_push($escalasMostrar, $escalasMostrarr);
            }
            return View::make('scales.index', ['scales' => $escalasMostrar]);
        }else{
            Redirect::toRoute('scales/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            $aeroportos = Airport::all();
            $avioes = Airplane::all();
            $voos = Flight::all();
            return View::make('scales.create', ['airports' => $aeroportos, 'airplanes' => $avioes, 'flights' => $voos]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Post::getAll();
            $escalas = new Scale($escala);
            $escalas->save();
            Redirect::toRoute('scales/index');
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
            $escala = Scale::first([$id]);
            $aeroportos = Airport::all();
            return View::make('scales.edit', ['escala' => [$escala], 'airports' => [$aeroportos]]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $escala = Scale::first([$id]);
            $escala->update_attributes(Post::getAll());
            $escala->save();
            Redirect::toRoute('scales/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $escala = Scale::first([$id]);
            $escala->delete();
            Redirect::toRoute('scales/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }
}
?>
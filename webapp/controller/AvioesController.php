<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
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
        Redirect::toRoute('avioes/index');

    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        $procura = ['IdAviao' => $id];
        $aviaoprocurar = Avioes::find($procura);
        $aviao = [
            'id' => $aviaoprocurar->idaviao,
            'nomeaviao' => $aviaoprocurar->nomeaviao,
            'transportadora' => $aviaoprocurar->transportadora
        ];
        return View::make('avioes.edit', ['aviao' => $aviao]);
    }

    public function update($id)
    {
        $aviao = Avioes::find([$id]);
        $aviao->update_attributes(Post::getAll());
        $aviao->save();

        Redirect::toRoute('avioes/index');
    }

    public function destroy($id)
    {
        $aviao = Avioes::find([$id]);
        $aviao->delete();
        Redirect::toRoute('avioes/index');
    }
}
?>
<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class AeroportosController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        $aeroportos = Aeroportos::all();
        return View::make('aeroportos.index', ['aeroportos' => $aeroportos]);
    }

    public function create()
    {
        return View::make('aeroportos.create');
    }

    public function store()
    {
        $aeroporto = Post::getAll();
        $aeroportos = new Aeroportos($aeroporto);
        $aeroportos->save();
        Redirect::toRoute('aeroportos/index');

    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function edit($id)
    {
        $aeroporto = Aeroportos::find([$id]);
        return View::make('aeroportos.edit', ['aeroporto' => [$aeroporto]]);
    }

    public function update($id)
    {
        $aeroporto = Aeroportos::find([$id]);
        $aeroporto->update_attributes(Post::getAll());
        $aeroporto->save();
        Redirect::toRoute('aeroportos/index');
    }

    public function destroy($id)
    {
        $aeroporto = Aeroportos::find([$id]);
        $aeroporto->delete();
        Redirect::toRoute('aeroportos/index');
    }
}
?>
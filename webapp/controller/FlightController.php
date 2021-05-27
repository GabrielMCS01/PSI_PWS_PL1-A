<?php

use ArmoredCore\Controllers\BaseController;
use ArmoredCore\Interfaces\ResourceControllerInterface;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;

class FlightController extends BaseController implements ResourceControllerInterface{

    public function index()
    {
        if(isset($_SESSION['username'])) {
            $voos = Flight::all();
            return View::make('flights.index', ['voos' => $voos, 'searchbar' => '']);
        }else{
            Redirect::toRoute('flights/index');
        }
    }

    public function create()
    {
        if(isset($_SESSION['username'])) {
            $aeroportos = Airport::all();
            $avioes = Airplane::all();
            return View::make('flights.create', ['airports' => $aeroportos, 'airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function store()
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $voo = Post::getAll();
            $voos = new Flight($voo);
            $voos->save();
            Redirect::toRoute('flights/index');
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
            $voo = Flight::first([$id]);
            $aeroportos = Airport::all();
            $avioes = Airplane::all();
            return View::make('flights.edit', ['voo' => $voo, 'airports' => $aeroportos, 'airplanes' => $avioes]);
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function update($id)
    {
        ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';
        if(isset($_SESSION['username'])) {
            $voo = Flight::first([$id]);
            $voo->update_attributes(Post::getAll());
            $voo->save();
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function destroy($id)
    {
        if(isset($_SESSION['username'])) {
            $voo = Flight::first([$id]);
            $voo->delete();
            Redirect::toRoute('flights/index');
        }else{
            Redirect::toRoute('users/index');
        }
    }

    public function search()
    {
        $searching = Post::get('search');

        $airport = Airport::first(['airportname' => $searching]);
        $airportid = (isset($airport))?$airport->airports_id:'';
        $aviao = Airplane::first(['airplanename' => $searching]);
        $aviaoid = (isset($aviao))?$aviao->airplanes_id:'';

        $search = Flight::find('all', array('conditions' =>
            "flightname LIKE '%$searching%' OR 
            datehourdeparture LIKE '%$searching%' OR
            datehourarrival LIKE '%$searching%' OR 
            origin_airport_id = '$airportid' OR
            destination_airport_id = '$airportid' OR
            airplane_id = '$aviaoid' OR
            price LIKE '%$searching%'
            "));
        return View::make('flights.index', ['voos' => $search, 'searchbar' => $searching]);
    }
}
?>
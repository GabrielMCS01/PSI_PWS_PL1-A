<?php

use ActiveRecord\Model;

class Airport extends Model{
    //Definição do modelo(objeto)
    // Um "Aeroporto" tem vários "Voos" e "Escalas"
    static $has_many = [
        //Voos
        ['origin_flight', 'foreign_key' =>'origin_airport_id', 'class_name' => 'Flight'],
        ['destination_flight', 'foreign_key' =>'destination_airport_id', 'class_name' => 'Flight'],
        //Escalas
        ['origin_scale', 'foreign_key' =>'originairport_id', 'class_name' => 'Scale'],
        ['destination_scale', 'foreign_key' =>'destinationairport_id', 'class_name' => 'Scale'],
    ];

    public function ListarPaises(){
        $json = file_get_contents('https://restcountries.eu/rest/v2/all');
        $paises = json_decode($json);
        return $paises;
    }

    public function DevolverBandeira($paisNome){
        foreach ($this->ListarPaises() as $pais){
            if($paisNome == $pais->name){
                return $pais->flag;
            }
        }
    }

    public function DevolverDistancia($pais1, $pais2){
        foreach ($this->ListarPaises() as $pais){
            if($pais1 == $pais->name){
                $pais1 = ['latitude' => $pais->latlng[0], 'longitude' => $pais->latlng[1]];
            }
            if($pais2 == $pais->name){
                $pais2 = ['latitude' => $pais->latlng[0], 'longitude' => $pais->latlng[1]];
            }
        }

        $lat1 = deg2rad($pais1['latitude']);
        $lat2 = deg2rad($pais2['latitude']);
        $lon1 = deg2rad($pais1['longitude']);
        $lon2 = deg2rad($pais2['longitude']);

        $dist = (6371 * acos( cos( $lat1 ) * cos( $lat2 ) * cos( $lon2 - $lon1 ) + sin( $lat1 ) * sin($lat2) ) );
        $dist = number_format($dist, 0, '.', '');
        return $dist;
    }
}
?>
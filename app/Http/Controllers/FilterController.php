<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class FilterController  extends Controller
{
    public function data(){
        $areas = App\WaterArea::select('name')->orderBy('id_water_area', 'asc')->get();
        $stations = App\ViewStation::select('id_station as key', 'station_name as value', 'id_water_area')->orderByRaw('id_water_area asc, id_station asc')->get();

        if($areas && $stations)
            return view('filterData', compact('areas', 'stations'));
        else
            return false;
    }
}
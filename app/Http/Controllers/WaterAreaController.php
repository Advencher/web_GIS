<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class WaterAreaController extends Controller
{
    public function forComboBox(){
        $waterAreas = App\WaterArea::all()->sortBy('id_water_area');
        return view('waterAreasCB', compact('waterAreas'));
    }
}
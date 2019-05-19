<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class HorizonLevelsController extends Controller
{
    public function ShowAllForComboBox(){
        $horizons = App\HorizonLevels::all();
        return view('horizonsCB', compact('horizons'));
    }

}

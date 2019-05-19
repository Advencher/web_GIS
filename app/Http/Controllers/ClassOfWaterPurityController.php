<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ClassOfWaterPurityController extends Controller
{
    public function forComboBox(){
        $waterPurites = App\ClassOfWaterPurity::all()->sortBy('id_class_of_purity');
        return view('waterPurityCB', compact('waterPurites'));
    }
}

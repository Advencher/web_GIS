<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class TrophicCharacterizationOfWaterController extends Controller
{
	public function ShowAllForComboBox(){
        $tropics = App\TrophicCharacterizationOfWater::all();
        return view('tropicCB', compact('tropics'));
    }
}
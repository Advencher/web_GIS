<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class SaprobityController extends Controller
{
    public function forComboBox(){
        $saprobities = App\Saprobity::all()->sortBy('id_saprobity');
        return view('saprobityCB', compact('saprobities'));
    }
}

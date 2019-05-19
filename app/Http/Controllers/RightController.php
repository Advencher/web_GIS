<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class RightController extends Controller
{
    public function allForCB(){
        $rights = App\Right::all();
        return view('rightsCB', compact('rights'));
    }

}
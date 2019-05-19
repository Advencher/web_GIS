<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
class SpGpOfPhytoplanktonController extends Controller
{

    public function ShowAllForComboBoxSp(){
        $species = App\SpeciesOfPhytoplankton::all();
        return view('speciesCB', compact('species'));
    }
    public function ShowAllForComboBoxGp(){
        $groups = App\GroupsOfPhytoplankton::all();
        return view('groupsCB', compact('groups'));
    }


}

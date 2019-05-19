<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class GroupsOfPhytoplanktonController extends Controller
{
    public function forComboBox(){
        $groups = App\GroupsOfPhytoplankton::all()->sortBy('id_group');
        return view('GroupsPaperItem', compact('groups'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class SpeciesOfPhytoplanktonController extends Controller
{
    public function speciesInfo(Request $request)
    {
        $id_species = $request->input('dataRow.id_species');
        $speciesInfo = App\SpeciesOfPhytoplankton::where('id_species', '=', $id_species)->first();
        $id_group = $speciesInfo->id_group;
        $group = App\GroupsOfPhytoplankton::where('id_group', '=', $id_group)->first();
        return $group;
    }

    public function insertNewSpecie (Request $request)

    {
        $id_group = $request->input('dataRow.id_group');
        $specie_name = $request->input('dataRow.specie_name');
        $maxId = App\SpeciesOfPhytoplankton::max('id_species');
        $maxId = $maxId + 1;

        $searchSpecie = App\SpeciesOfPhytoplankton::where('name', '=', $specie_name) -> first();
        if ($searchSpecie){
            return 'alreadyExist';
        }

        else {
            $newSpecie = App\SpeciesOfPhytoplankton::create(['id_species' => $maxId, 'id_group' => $id_group, 'name' => $specie_name])->save();
            return 'success';

        }


    }


}

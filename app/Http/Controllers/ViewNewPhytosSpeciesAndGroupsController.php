<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ViewNewPhytosSpeciesAndGroupsController extends Controller
{

    public function ShowPageSpGp(Request $request){
        $id_phyto =  $request->input('id_phyto');
        return view('SpeciesAndGroupsOfPhytoSample', compact('id_phyto'));
    }


    public function ShowPhytosSpecies(Request $request)
    {
        /**$t = $request->input('t');*/
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');

        $id_phyto =  $request->input('id_phyto');

       if ($sortBy === 'SpecieName')
            $sortBy = 'specie_name ' .$direction;
        if ($sortBy === 'GroupName')
            $sortBy = 'group_name ' .$direction;

        $limit = $request->input('limit');
        $count = App\ViewNewPhytosSp::where('id_phyto','=', $id_phyto)->count();
        $phytos = App\ViewNewPhytosSp::
        where('id_phyto','=', $id_phyto) ->
        when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->paginate($limit);

        return view('PhytosSP', compact('phytos', 'count'));
    }

    public function ShowPhytosGroups(Request $request)
    {
        /**$t = $request->input('t');*/
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');

        $id_phyto =  $request->input('id_phyto');

//        if ($sortBy === 'Date')
//            $sortBy = 'date ' .$direction;
//        if ($sortBy === 'Station')
//            $sortBy = 'water_area_name ' .$direction  .', station_name ' .$direction;

        $limit = $request->input('limit');
        $count = App\ViewNewPhytosGp::where('id_phyto','=', $id_phyto)->count();
        $phytos = App\ViewNewPhytosGp::
        where('id_phyto','=', $id_phyto) ->
        when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->paginate($limit);

        return view('PhytosGP', compact('phytos', 'count'));
    }


    public function update_species_in_phyto_sample(Request $request)
    {
        $id_specie_in_phyto = $request->input('dataRow.id_specie_in_phyto');
        $id_species = $request->input('dataRow.id_species');
        $percentage_of_total = $request->input('dataRow.percentage_of_total');
        $percentage_of_the_total_biomass = $request->input('dataRow.percentage_of_the_total_biomass');
        $number = $request->input('dataRow.number');
        $biomass = $request->input('dataRow.biomass');

        $affectedRows = App\ViewNewPhytosSp::where('id_specie_in_phyto', '=', $id_specie_in_phyto )
            ->update([
                'id_specie_in_phyto' => $id_specie_in_phyto,
                'id_species' => $id_species,
                'percentage_of_total' => $percentage_of_total,
                'percentage_of_the_total_biomass' => $percentage_of_the_total_biomass,
                'number' => $number,
                'biomass' => $biomass
            ]);
        return $affectedRows;
    }

    public function insert_species_in_phyto_sample(Request $request)
    {
        $id_phyto = $request->input('dataRow.id_phyto');
        $id_species = $request->input('dataRow.id_species');
        $percentage_of_total = $request->input('dataRow.percentage_of_total');
        $percentage_of_the_total_biomass = $request->input('dataRow.percentage_of_the_total_biomass');
        $number = $request->input('dataRow.number');
        $biomass = $request->input('dataRow.biomass');


        $newSample = App\ViewNewPhytosSp::create(
            [   'id_phyto' => $id_phyto,
                'id_species' => $id_species,
                'percentage_of_total' => $percentage_of_total,
                'percentage_of_the_total_biomass' => $percentage_of_the_total_biomass,
                'number' => $number,
                'biomass' => $biomass,
               ])-> save();

    }


    public function delete_species_in_phyto_sample(Request $request)
    {
        $id_specie_in_phyto = $request->input('dataRow.id_specie_in_phyto');
        $deletePhyto = App\ViewNewPhytosSp::where('id_specie_in_phyto', '=', $id_specie_in_phyto)->delete();
//

            return $deletePhyto;
    }


    public function maxIDSpecies(){
        $maxId = App\ViewNewPhytosSp::max('id_specie_in_phyto');
        if ($maxId)
            return $maxId;
        else
            return false;
    }

    public function maxIDGroups(){
        $maxId = App\ViewNewPhytosGp::max('id_group_in_phyto');
        if ($maxId)
            return $maxId;
        else
            return false;
    }


    public function update_group_in_phyto_sample(Request $request)
    {
        $id_group_in_phyto = $request->input('dataRow.id_group_in_phyto');
        $id_group = $request->input('dataRow.id_group');
        $total_species_in_group = $request->input('dataRow.total_species_in_group');
        $total_percent = $request->input('dataRow.total_percent');
        $biomass_percent = $request->input('dataRow.biomass_percent');
        $number = $request->input('dataRow.number');
        $biomass = $request->input('dataRow.biomass');

        $affectedRows = App\ViewNewPhytosGp::where('id_group_in_phyto', '=', $id_group_in_phyto )
            ->update([
                'id_group_in_phyto' => $id_group_in_phyto,
                'id_group' => $id_group,
                'total_species_in_group' => $total_species_in_group,
                'total_percent' => $total_percent,
                'biomass_percent' => $biomass_percent,
                'number' => $number,
                'biomass' => $biomass
            ]);
       return $affectedRows;
    }

    public function insert_group_in_phyto_sample(Request $request)
    {
        $id_phyto = $request->input('dataRow.id_phyto');
        $id_group = $request->input('dataRow.id_group');
        $total_species_in_group = $request->input('dataRow.total_species_in_group');
        $total_percent = $request->input('dataRow.total_percent');
        $biomass_percent = $request->input('dataRow.biomass_percent');
        $number = $request->input('dataRow.number');
        $biomass = $request->input('dataRow.biomass');


        $newSample = App\ViewNewPhytosGp::create(
            [   'id_phyto' => $id_phyto,
                'id_group' => $id_group,
                'number' => $number,
                'biomass' => $biomass,
                'total_species_in_group' => $total_species_in_group,
                'total_percent' => $total_percent,
                'biomass_percent' => $biomass_percent,
            ])-> save();

    }


    public function delete_group_in_phyto_sample(Request $request)
    {
        $id_group_in_phyto = $request->input('dataRow.id_group_in_phyto');
        $deletePhyto = App\ViewNewPhytosGp::where('id_group_in_phyto', '=', $id_group_in_phyto)->delete();


           return $deletePhyto;


    }

}

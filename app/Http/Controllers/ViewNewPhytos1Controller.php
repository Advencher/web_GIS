<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App;

class ViewNewPhytos1Controller extends Controller
{

    public function OnePhytoMain(Request $request){
        $id_phyto =  $request->input('id_phyto');
        return view('onePhytoMain', compact('id_phyto'));
    }


    public function ShowPage(){

        return view('Phytoplankton');
    }

    public function ShowPhytos(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $stations = $request->input('stations');
        $waterAreas = $request->input('waterAreas');
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');

        if ($sortBy === 'ID')
            $sortBy = 'id_phyto ' .$direction;
        if ($sortBy === 'Date')
            $sortBy = 'date ' .$direction;
        if ($sortBy === 'Station')
            $sortBy = 'water_area_name ' .$direction  .', station_name ' .$direction;

        $limit = $request->input('limit');

        if (!$startDate && !$endDate && !$stations && !$waterAreas)
            $count = App\ViewNewPhytos1::all()->count();
        else
            $count = App\ViewNewPhytos1::when($startDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })->when($stations, function ($query) use ($stations ) {
                return $query->whereIn('id_station', explode(',',$stations));
            })->when($waterAreas, function ($query) use ($waterAreas ) {
                return $query->whereIn('water_area_name', explode(',',$waterAreas));
            })->count();

        $phytos = App\ViewNewPhytos1::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->when($startDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->when($stations, function ($query) use ($stations ) {
            return $query->whereIn('id_station', explode(',',$stations));
        })->when($waterAreas, function ($query) use ($waterAreas ) {
            return $query->whereIn('water_area_name', explode(',',$waterAreas));
        })->paginate($limit);

        foreach  ($phytos as  $phyto) {
            $phyto->longitude = round($phyto->longitude, 2);
            $phyto->latitude = round($phyto->latitude, 2);
            $phyto->time = substr($phyto->date, 11, 8);
            $phyto->utc = substr($phyto->date, 19, 3);
            $day = (int) substr($phyto->date, 8, 2);
            $month = (int) substr($phyto->date, 5, 2);
            $year = (int) substr($phyto->date, 0, 4);
            $phyto->date = mktime(0, 0, 0, $month, $day, $year)*1000;
        }
        return view('Phytos1', compact('phytos', 'count'));
    }

    public function ShowOnePhyto(Request $request){

        $id_sample = $request->input('id_sample');
        $limit = $request->input('limit');
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');

        if ($sortBy === 'ID')
            $sortBy = 'id_phyto ' .$direction;
        if ($sortBy === 'Date')
            $sortBy = 'date ' .$direction;
        if ($sortBy === 'Station')
            $sortBy = 'water_area_name ' .$direction  .', station_name ' .$direction;

        $count = App\ViewNewPhytos1::where('id_sample', '=', $id_sample)->count();
        //$phytos = App\ViewNewPhytos1::where('id_sample', '=', $id_sample)->paginate($limit);

        $phytos = App\ViewNewPhytos1::where('id_sample', '=', $id_sample)->when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->paginate($limit);

        foreach  ($phytos as  $phyto) {
            $phyto->longitude = round($phyto->longitude, 2);
            $phyto->latitude = round($phyto->latitude, 2);
            $phyto->time = substr($phyto->date, 11, 8);
            $phyto->utc = substr($phyto->date, 19, 3);
            $day = (int) substr($phyto->date, 8, 2);
            $month = (int) substr($phyto->date, 5, 2);
            $year = (int) substr($phyto->date, 0, 4);
            $phyto->date = mktime(0, 0, 0, $month, $day, $year)*1000;
        }
        return view('Phytos1', compact('phytos', 'count'));
    }

    public function update_phyto1(Request $request)
    {

        $id_phyto = $request->input('dataRow.id_phyto');
        $id_horizon = $request->input('dataRow.id_horizon');
        $total = $request->input('dataRow.total');
        $total_species = $request->input('dataRow.total_species');
        $total_biomass = $request->input('dataRow.total_biomass');
        $total_percent = $request->input('dataRow.total_percent');
        $biomass_percent = $request->input('dataRow.biomass_percent');
        $id_saprobity =  $request->input('dataRow.id_saprobity');
        $id_class_of_purity =  $request->input('dataRow.id_class_of_purity');
        $upholding_sample_time =  $request->input('dataRow.upholding_sample_time');
        $concentrated_sample_volume =  $request->input('dataRow.concentrated_sample_volume');
        $cameras_viewed_number =  $request->input('dataRow.cameras_viewed_number');

        $affectedRows = App\ViewNewPhytos1::where('id_phyto', '=', $request->input('dataRow.id_phyto') )
            ->update([
                'id_phyto' => $id_phyto,
                'id_horizon' => $id_horizon,
                'id_saprobity' => $id_saprobity,
                'id_class_of_purity' => $id_class_of_purity,
                'total' => $total,
                'total_species' => $total_species,
                'total_biomass' => $total_biomass,
                'total_percent' => $total_percent,
                'biomass_percent' => $biomass_percent,
                'upholding_sample_time' => $upholding_sample_time,
                'concentrated_sample_volume' => $concentrated_sample_volume,
                'cameras_viewed_number' => $cameras_viewed_number
            ]);

        if ($affectedRows)
            return 'success';
        else
            return false;
    }


    public function delete_phyto1(Request $request)
    {
        $id_phyto = $request->input('dataRow.id_phyto');

        try {
            $deletePhyto = App\ViewNewPhytos1::where('id_phyto', '=', $id_phyto)->delete();

        } catch (QueryException $e) {
            if ($e->errorInfo[0] == '23503')
                return 'Запись не удалена! 
        У пробы с ID ' .$id_phyto .' есть данные о группах и видах фитопланктона в пробе.
        Сначала удалите их!';
            else
                return false;
        }

        if ($deletePhyto)
            return 'success';
        else
            return false;
    }

    public function insert_phyto1(Request $request)
    {
        $id_sample = $request->input('dataRow.id_sample');
        $id_phyto = $request->input('dataRow.id_phyto');
        $id_horizon = $request->input('dataRow.id_horizon');
        $total = $request->input('dataRow.total');
        $total_species = $request->input('dataRow.total_species');
        $total_biomass = $request->input('dataRow.total_biomass');
        $total_percent = $request->input('dataRow.total_percent');
        $biomass_percent = $request->input('dataRow.biomass_percent');
        $id_saprobity =  $request->input('dataRow.id_saprobity');
        $id_class_of_purity =  $request->input('dataRow.id_class_of_purity');
        $upholding_sample_time =  $request->input('dataRow.upholding_sample_time');
        $concentrated_sample_volume =  $request->input('dataRow.concentrated_sample_volume');
        $cameras_viewed_number =  $request->input('dataRow.cameras_viewed_number');

        $newSample = App\ViewNewPhytos1::create(
            [   'id_phyto' => $id_phyto,
                'id_sample' => $id_sample,
                'id_horizon' => $id_horizon,
                'id_saprobity' => $id_saprobity,
                'id_class_of_purity' => $id_class_of_purity,
                'total' => $total,
                'total_species' => $total_species,
                'total_biomass' => $total_biomass,
                'total_percent' => $total_percent,
                'biomass_percent' => $biomass_percent,
                'upholding_sample_time' => $upholding_sample_time,
                'concentrated_sample_volume' => $concentrated_sample_volume,
                'cameras_viewed_number' => $cameras_viewed_number ])-> save();
        //return $newSample;
    }

    public function maxID(){
        $maxId = App\ViewNewPhytos1::max('id_phyto');
        return $maxId;
    }

    public function update_phyto2(Request $request)
    {

        $id_phyto =  $request->input('dataRow.id_phyto');
        $id_saprobity =  $request->input('dataRow.id_saprobity');
        $id_class_of_purity =  $request->input('dataRow.id_class_of_purity');
        $upholding_sample_time =  $request->input('dataRow.upholding_sample_time');
        $concentrated_sample_volume =  $request->input('dataRow.concentrated_sample_volume');
        $cameras_viewed_number =  $request->input('dataRow.cameras_viewed_number');


        $affectedRows = App\ViewNewPhytos1::where('id_phyto', '=', $id_phyto)->
            update([
                'id_phyto' => $id_phyto,
                'id_saprobity' => $id_saprobity,
                'id_class_of_purity' => $id_class_of_purity,
                'upholding_sample_time' => $upholding_sample_time,
                'concentrated_sample_volume' => $concentrated_sample_volume,
                'cameras_viewed_number' => $cameras_viewed_number
            ]);
        //сколько строк проапдейтилось
        return $affectedRows;
    }

}

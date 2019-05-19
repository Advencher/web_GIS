<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ViewNewPigmentsController extends Controller
{
	public function ShowAll2(Request $request)
    {
		$sid = $request->input('sid');
		$startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $stations = $request->input('stations');
        $waterAreas = $request->input('waterAreas');
		
        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');
        if ($sortBy === 'ID')
            $sortBy = 'id_pps '  .$direction;
        if ($sortBy === 'Date')
            $sortBy = 'date ' .$direction;
        if ($sortBy === 'Station')
            $sortBy = 'waterarea ' .$direction  .', station ' .$direction;
        $limit = $request->input('limit');
		
		if (!$startDate && !$endDate && !$stations && !$waterAreas && !$sid)
            $count = App\ViewNewPigments::all()->count();
        else
            $count = App\ViewNewPigments::when($startDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })->when($stations, function ($query) use ($stations ) {
                return $query->whereIn('id_station', explode(',',$stations));
			})->when($sid, function ($query) use ($sid ) {
				return $query->whereIn('id_sample', explode(',',$sid));
            })->when($waterAreas, function ($query) use ($waterAreas ) {
                return $query->whereIn('waterarea', explode(',',$waterAreas));
            })->count();


        $pigments = App\ViewNewPigments::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->when($startDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->when($stations, function ($query) use ($stations ) {
            return $query->whereIn('id_station', explode(',',$stations));
		})->when($sid, function ($query) use ($sid ) {
            return $query->whereIn('id_sample', explode(',',$sid));
        })->when($waterAreas, function ($query) use ($waterAreas ) {
            return $query->whereIn('waterarea', explode(',',$waterAreas));
        })->paginate($limit);
		
/*         if(isset($sid))
		{
			$count = App\ViewNewPigments::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
			})->where('id_sample', '=', $sid)->count();
			$pigments = App\ViewNewPigments::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
			})->where('id_sample', '=', $sid)->paginate($limit);
		}
		else
		{
			$count = App\ViewNewPigments::all()->count();
			$pigments = App\ViewNewPigments::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
			})->paginate($limit);
		} */
		//where('id_sample', '=', $request->input('sid'))->
		
        foreach  ($pigments as  $pigment) {
            $pigment->chla = round($pigment->chla, 2);
			$pigment->chlb = round($pigment->chlb, 2);
			$pigment->chlc = round($pigment->chlc, 2);
			$pigment->longitude = round($pigment->longitude, 2);
            $pigment->latitude = round($pigment->latitude, 2);
			$pigment->a665k = round($pigment->a665k, 2);
			$pigment->volumeoffilteredwater = round($pigment->volumeoffilteredwater, 2);
			//$pigment->trophiccharacteristics = round($pigment->trophiccharacteristics, 2);
			$pigment->pigmentindex = round($pigment->pigmentindex, 2);
			$pigment->pheopigments = round($pigment->pheopigments, 2);
            // $sample->time = substr($sample->date, 11, 8);
            // $sample->utc = substr($sample->date, 19);
           // if (strlen($sample->date) > 22)
               // $sample->utc = '03';
           // else

            // $day = (int) substr($sample->date, 8, 2);
            // $month = (int) substr($sample->date, 5, 2);
            // $year = (int) substr($sample->date, 0, 4);
            // $sample->date = mktime(0, 0, 0, $month, $day, $year)*1000;
        }
        return view('Test2pg', compact('pigments', 'count'));
    }
	
	public function ShowAll(){
        $pigments = App\ViewNewPigments::paginate(15);
        return view('AllPigmentsView', compact('pigments'));
    }
	
	public function pigments_count(Request $request){ 
		$pc = App\ViewNewPigments::where('id_sample', '=', $request->input('id_sample'))->count('id_pps'); 
		return $pc; 
		//http://127.0.0.1:8000/pigmentsCount?id_sample=109
	}
	
    public function delete_pigment(Request $request)
    {
        $id_pps = $request->input('dataRow.id_pps');
        $deletePigment = App\ViewNewPigments::where('id_pps', '=', $id_pps)->delete();
		if ($deletePigment)
                    return 'success';
                else
                    return false;
    }
	
	public function insert_pigment(Request $request)
    {
        $id_pigment = $this->maxID();
        if($id_pigment){
            //$id_sample = $request->input('sid');
			$id_sample = $request->input('dataRow.id_sample');
            $newPigment = App\ViewNewPigments::create(['id_pps' => $id_pigment,
                'id_sample' => $id_sample])-> save();
            if($newPigment)
                return $id_pigment;
            else
                return false;
        }
        else
            return false;
    }
	
	public function maxID(){
		$maxId = App\ViewNewPigments::max('id_pps');
		if ($maxId)
		    return $maxId + 1;
		else
		    return false;
	}
	
	public function update_pigment(Request $request)
    {
        $id_pps = $request->input('dataRow.id_pps');
        $comment = $request->input('dataRow.comment');
		if($comment == "") $comment = NULL;
        $serial_number = $request->input('dataRow.serial_number');
		if($serial_number == "") $serial_number = NULL;
		$trop_id = $request->input('dataRow.trop_id');
		if($trop_id == 0) $trop_id = NULL;
		$volumeoffilteredwater = $request->input('dataRow.volumeoffilteredwater');
		$chla = $request->input('dataRow.chla');
		$chlb = $request->input('dataRow.chlb');
		$chlc = $request->input('dataRow.chlc');
		$a665k = $request->input('dataRow.a665k');
		$pigmentindex = $request->input('dataRow.pigmentindex');
		$pheopigments = $request->input('dataRow.pheopigments');

        $affectedRows = App\ViewNewPigments::where('id_pps', '=', $id_pps )->
        update(['comment' => $comment,
            'pps_serial' => $serial_number,
            'trop_id' => $trop_id,
			'volumeoffilteredwater' => $volumeoffilteredwater,
			'chla' => $chla,
			'chlb' => $chlb,
			'chlc' => $chlc,
			'a665k' => $a665k,
			'pigmentindex' => $pigmentindex,
            'pheopigments' => $pheopigments]);
        //сколько строк проапдейтилось
        if ($affectedRows)
            return 'success';
        else
            return false;
    }
}
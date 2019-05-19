<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use DateTime;
use App;


class ViewNewSamplesController extends  Controller
{

    public function all(Request $request)
    {
        /**$t = $request->input('t');*/

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $stations = $request->input('stations');
        $waterAreas = $request->input('waterAreas');

        $sortBy = $request->input('sortBy');
        $direction = $request->input('direction');
        if ($sortBy === 'ID')
            $sortBy = 'id_sample '  .$direction;
        if ($sortBy === 'SerialNumber')
            $sortBy = 'serial_number ' .$direction;
        if ($sortBy === 'Date')
            $sortBy = 'date ' .$direction;
        if ($sortBy === 'Station')
            $sortBy = 'water_area_name ' .$direction  .', station_name ' .$direction;

        $limit = $request->input('limit');

        if (!$startDate && !$endDate && !$stations && !$waterAreas)
            $count = App\ViewNewSamples::all()->count();
        else
            $count = App\ViewNewSamples::when($startDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('date', [$startDate, $endDate]);
            })->when($stations, function ($query) use ($stations ) {
                return $query->whereIn('id_station', explode(',',$stations));
            })->when($waterAreas, function ($query) use ($waterAreas ) {
                return $query->whereIn('water_area_name', explode(',',$waterAreas));
            })->count();


        $samples = App\ViewNewSamples::when($sortBy, function ($query) use ($sortBy) {
            return $query->orderByRaw($sortBy);
        })->when($startDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->when($stations, function ($query) use ($stations ) {
            return $query->whereIn('id_station', explode(',',$stations));
        })->when($waterAreas, function ($query) use ($waterAreas ) {
            return $query->whereIn('water_area_name', explode(',',$waterAreas));
        })->paginate($limit);


        foreach  ($samples as  $sample) {
            $sample->longitude = round($sample->longitude, 2);
            $sample->latitude = round($sample->latitude, 2);
            $sample->time = substr($sample->date, 11, 8);
            $sample->utc = substr($sample->date, 19);
//            if (strlen($sample->date) > 22)
//                $sample->utc = '03';
//            else
//
            $day = (int) substr($sample->date, 8, 2);
            $month = (int) substr($sample->date, 5, 2);
            $year = (int) substr($sample->date, 0, 4);
            $sample->date = mktime(0, 0, 0, $month, $day, $year)*1000;
        }
        return view('samples_grid', compact('samples', 'count'));
    }

    public function update_sample(Request $request)
    {
        $date = $request->input('dataRow.date');
        if ($this->validateDate($date)) {
            if ($this->checkDate($request)) {
                $id_sample = $request->input('dataRow.id_sample');

                $comment = $request->input('dataRow.comment');
                $serial_number = $request->input('dataRow.serial_number');
                $id_station = $request->input('dataRow.id_station');

                $affectedRows = App\ViewNewSamples::where('id_sample', '=', $id_sample)->
                update(['id_sample' => $id_sample,
                    'date' => $date,
                    'comment' => $comment,
                    'serial_number' => $serial_number,
                    'id_station' => $id_station]);
                //сколько строк проапдейтилось
                if ($affectedRows)
                    return 'success';
                else
                    return false;
            } else
                return $this->minDate($request);
        }
        else
            return 'Данные не обновлены!
Не корректное поле «Дата» или «Время»';
    }


    public function insert_sample(Request $request)
    {
        $date = $request->input('dataRow.date');
        if ($this->validateDate($date)) {
            $id_sample = $this->maxID();
            if ($id_sample) {
                $id_station = $request->input('dataRow.id_station');

                $comment = $request->input('dataRow.comment');
                $serial_number = $request->input('dataRow.serial_number');

                $newSample = App\ViewNewSamples::create(['id_sample' => $id_sample,
                    'id_station' => $id_station,
                    'date' => $date,
                    'comment' => $comment,
                    'serial_number' => $serial_number])->save();
                if ($newSample)
                    return $id_sample;
                else
                    return false;
            } else
                return false;
            //$id_sample = $request->input('dataRow.id_sample');

            //return $newSample;
        }
        else
            return false;
    }

    public function delete_sample(Request $request)
    {
        $id_sample = $request->input('dataRow.id_sample');
        try {
            $deleteSample = App\ViewNewSamples::where('id_sample', '=', $id_sample)->delete();

        } catch (QueryException $e) {
            if ($e->errorInfo[0] == '23503')
                return 'Запись не удалена! 
У пробы с ID ' .$id_sample .' есть данные о фитопланктоне и/или фотосинтетических пигментах.
Сначала удалите их!';
            else
                return false;
        }
		
		if ($deleteSample)
                    return 'success';
                else
                    return false;

        //return $deleteSample;
    }
	
	public function maxID(){
		$maxId = App\ViewNewSamples::max('id_sample');
		if ($maxId)
		    return $maxId + 1;
		else
		    return false;
	}

    public function info(Request $request){
        $id_sample = $request->input('dataRow.id_sample');

        $row = App\ViewNewSamples::select('longitude', 'latitude', 'date')
            ->where('id_sample', '=', $id_sample )
            ->first();

        if($row){
            $row->longitude = (string)round($row->longitude, 2);
            $row->latitude = (string)round($row->latitude, 2);
//            $row->time = (string)substr($row->date, 11, 8);
            $row->utc = (string)substr($row->date, 19);
//            $day = substr($row->date, 8, 2);
//            $month = substr($row->date, 5, 2);
//            $year = substr($row->date, 0, 4);
//            $row->date = $day .'/' .$month .'/' .$year;
            return $row;
        }
        else
            return $row;
    }

    public function checkDate(Request $request){
        $id_station = $request->input('dataRow.id_station');
        $date = $request->input('dataRow.date');

        $row = App\StationCoord::where([
            ['id_station', '=', $id_station],
            ['date', '<=', $date],
        ])->first();

        //return $date;
        //return !!$row;
        if($row)
            return $row;
        else
            return false;
    }

    public function minDate(Request $request){
        $id_station = $request->input('dataRow.id_station');
        $name = $request->input('dataRow.name');

        $date = App\StationCoord::where('id_station', '=' , $id_station)
            ->min('date');

        if($date)
            return 'Данные не обновлены!
Минимальная дата для станции ' . $name . ' - ' .  $date;
        else
            return 'Данные не обновлены!
Минимальная дата для станции '. $name . ' не получена.
Повторите попытку или обратитесь к администратору!';
    }

    public function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
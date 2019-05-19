<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class StationsController extends Controller
{
    public function allCB(){//ComboBox
        $stations = App\ViewStation::all();
        return view('stationsCB', compact('stations'));
    }

    public function insert_station(Request $request)
    {
        $station_name = $request->input('dataRow.station_name');
        $longitude = $request->input('dataRow.longitude');
        $latitude = $request->input('dataRow.latitude');
        if($this->validateData($station_name, $longitude, $latitude)) {
            $id_station = $this->maxIDStation();
            $id_station_coord = $this->maxIDStationCoord();
            if ($id_station && $id_station_coord) {
                $id_water_area = $request->input('dataRow.id_water_area');
                $station_serial_number = $request->input('dataRow.station_serial_number');


                $longitude_str = $longitude;
                $latitude_str = $latitude;
                $newStation = App\ViewStation::create([
                    'id_station' => $id_station,
                    'id_station_coord' => $id_station_coord,
                    'station_name' => $station_name,
                    'id_water_area' => $id_water_area,
                    'station_serial_number' => $station_serial_number,
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'longitude_str' => $longitude_str,
                    'latitude_str' => $latitude_str])->save();
                if ($newStation)
                    return (string)$newStation;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }

    public function maxIDStation(){
        $maxId = App\ViewStation::max('id_station');
        if ($maxId)
            return $maxId + 1;
        else
            return false;
    }

    public function maxIDStationCoord(){
        $maxId = App\StationCoord::max('id_station_coord');
        if ($maxId)
            return $maxId + 1;
        else
            return false;
    }

    public function validateData($station_name, $longitude, $latitude){
        if (
                preg_match('~^.{1,64}$~',$station_name)
                &&
                preg_match('~^[-+]?((1[1-7]?[0-9]\.[0-9]{0,9}[1-9])|(1[1-7]?[0-9])|([1-9]?[0-9]\.[0-9]{0,9}[1-9])|([1-9]?[0-9])|(180))$~',$longitude)
                &&
                preg_match('~^[-+]?(([1-8]?[0-9]\.[0-9]{0,9}[1-9])|([1-8]?[0-9])|(90))$~',$latitude)
            )
            return true;
        else
            return false;
}
}

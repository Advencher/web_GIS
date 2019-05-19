<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewStation extends Model
{
    public $timestamps = false;
    protected $fillable = ['id_station', 'id_station_coord', 'station_name', 'id_water_area', 'station_serial_number', 'longitude', 'latitude', 'longitude_str', 'latitude_str'];
    protected $primaryKey = 'id_station';
}

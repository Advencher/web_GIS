<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewNewPigments extends Model
{
    public $timestamps = false;
    //protected $fillable = ['id_sample', 'id_station', 'date', 'comment', 'serial_number', 'station_name', 'water_area_name'];
	protected $fillable = ['id_pps', 'id_sample'];
	protected $primaryKey = 'id_pps';
}

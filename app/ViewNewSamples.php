<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewNewSamples extends Model
{
    public $timestamps = false;
    protected $table = 'view_new_samples3';
    protected $fillable = ['id_sample', 'id_station', 'date', 'comment', 'serial_number', 'station_name', 'water_area_name'];
    protected $primaryKey = 'id_sample';
}

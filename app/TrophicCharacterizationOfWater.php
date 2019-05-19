<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrophicCharacterizationOfWater extends Model
{
    public $timestamps = false;
    //protected $fillable = ['id_sample', 'id_station', 'date', 'comment', 'serial_number', 'station_name', 'water_area_name'];
	protected $primaryKey = 'id_trophic_characterization';
	protected $table = 'trophic_characterization_of_water';
}

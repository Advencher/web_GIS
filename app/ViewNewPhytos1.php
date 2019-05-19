<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewNewPhytos1 extends Model
{
    public $table = 'view_new_phytos1';
    public $timestamps = false;
    protected $fillable = ['id_phyto', 'id_sample', 'id_station', 'water_area_name',
        'station_name', 'id_horizon', 'horizon', 'upholding_sample_time',
        'concentrated_sample_volume', 'cameras_viewed_number', 'total',
        'total_species', 'total_biomass', 'total_percent', 'biomass_percent',
        'id_class_of_purity', 'water_purity_name','id_saprobity', 'saprobity_name'];
    protected $primaryKey = 'id_phyto';
}

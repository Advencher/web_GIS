<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewNewPhytosSp extends Model
{
    protected $table = 'view_new_phytos2';
    public $timestamps = false;
    protected $fillable = ['id_phyto', 'id_species', 'percentage_of_total', 'percentage_of_the_total_biomass', 'number', 'biomass', 'specie_name', 'id_group'];
    protected $primaryKey = 'id_phyto';

}

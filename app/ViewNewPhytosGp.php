<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewNewPhytosGp extends Model
{
    protected $table = 'view_new_phytos3';
    public $timestamps = false;
    protected $fillable = ['id_phyto', 'id_group', 'number', 'biomass', 'total_species_in_group', 'total_percent', 'biomass_percent'];
    protected $primaryKey = 'id_phyto';
}

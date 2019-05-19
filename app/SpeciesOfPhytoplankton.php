<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpeciesOfPhytoplankton extends Model
{
    protected $table = 'species_of_phytoplankton';
    public $timestamps = false;
    protected $fillable = ['id_species', 'id_group', 'name'];
    protected $primaryKey = 'id_species';
}

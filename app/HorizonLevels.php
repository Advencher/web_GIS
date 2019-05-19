<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorizonLevels extends Model
{
    public $timestamps = false;
    protected $fillable = ['id_horizon', 'name', 'upper_horizon_level', 'lower_horizon_level'];
    protected $primaryKey = 'id_horizon';
}

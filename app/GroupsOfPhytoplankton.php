<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupsOfPhytoplankton extends Model
{
    protected $table = 'groups_of_phytoplankton';
    public $timestamps = false;
    protected $primaryKey = 'id_group';
}

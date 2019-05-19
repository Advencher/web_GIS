<?php
//

namespace App;

use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    protected $table = 'view_users';
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'email', 'id_right'];
    protected $primaryKey = 'id';
}

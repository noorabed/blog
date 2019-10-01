<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class permission extends Model
{
    protected $guarded = [];
//    public function roles()
//    {
//        return $this->belongsToMany('App\Role','permission_role');
//    }

    public function roles(){
        return $this->belongsToMany('App\Role','action_roles');
    }

    public function users(){
        return $this->belongsToMany('App\User','action_roles');
    }
}

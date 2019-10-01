<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

//    public function permissions()
//    {
//        return $this->belongsToMany('App\Permission','permission_role');
//    }
//
//    public function users()
//    {
//        return $this->hasMany('App\User');
//    }

    public function permissions(){
        return $this->belongsToMany('App\Permission','action_roles');
    }

    public function users(){
        return $this->belongsToMany('App\User','action_roles');
    }
}

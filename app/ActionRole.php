<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionRole extends Model
{
    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }


}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=[];
    /*protected $fillable = [
        'name', 'email', 'password', 'state', 'user_photo','role_id',
    ];*/

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs()
    {
        return $this->hasMany('App\Blog');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

//    public function roles()
//    {
//        return $this->belongsTo('App\Role');
//
//    }

//    public function roles(){
//        return $this->belongsToMany('App\Role','action_roles');
//    }

    public function permissions(){
        return $this->belongsToMany('App\Permission','action_roles');
    }
    public function visitor()
    {
        return $this->hasMany('App\Vistor');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

}

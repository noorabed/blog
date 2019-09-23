<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $guarded=[];

    public function blogs()
    {
        return $this->belongsTo('App\Blog');
    }
  /*public function user()
    {
        return $this->belongsTo('App\User');
    }*/

    public function replies()
    {
        return $this->hasMany('App\Comment','parent_id','id');
    }
    public function commentParent(){
        return $this->belongsTo('App\Comment', 'parent_id');
    }

//    public function parent()
//    {
//        return $this->belongsTo('App\Comment', 'parent_id');
//    }
//
//    public function children()
//    {
//        return $this->hasMany('App\Comment', 'parent_id');
//    }
}


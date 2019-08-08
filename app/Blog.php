<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
   // protected $fillable =['post_tittle', 'post_descripition', 'post_photo' ,''];
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
//
//    public function categories()
//    {
//        return $this->belongsToMany('App\Category','category_blog');
//    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
}



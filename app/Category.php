<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =['title'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $table = 'categories';
//    public function blogs()
//    {
//        return $this->belongsToMany('App\Blog','category_blog');
//    }

    public function posts()
    {
        return $this->hasMany('App\Blog');
    }


    public function getRouteKeyName()

    {
        return 'slug';
    }

}

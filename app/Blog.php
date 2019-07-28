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
        //return $this->belongsTo(User::class);
    }
    //protected $table = 'blogs';
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_blog');
    }
}



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
    public function blogs()
    {
        return $this->belongsToMany(Blog::class,'category_blog');
    }
}

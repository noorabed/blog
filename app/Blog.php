<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

class Blog extends Model
{
    // protected $fillable =['post_tittle', 'post_descripition', 'post_photo' ,''];

    protected $guarded = [];
    protected  $dates =['published_at'];
    protected  $appends = [''];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function setPublishedAttribute($value)
    {
        $this->attributes['published_at']=$value? :Null;
    }

    public function getDateAttribute($value)
    {
        return is_null($this->published_at)? '': $this->published_at->diffForHumans();
    }



    public function scopeLatestFirst()
    {
        return $this->orderBy('published_at','desc');
    }
    public function scopePublished()
    {
        return $this->where("published_at","<=",Carbon::now());
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'blog_tag');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function commentsNumber($label = 'Comment')
    {
        $commentsNumber = $this->comments->count();
        return $commentsNumber . "" . str_plural($label, $commentsNumber);
    }
    public function getTagsHtmlAttribute()
    {
        $anchors = [];
        foreach ($this->tags as $tag){
            $anchors[] = '<a href="' . route('tag', $tag->second_name) . '">' . $tag->name . '</a>';
        }
        return implode(",",$anchors);
    }



}



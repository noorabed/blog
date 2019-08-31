<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Blog;
class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->truncate();

        $php = new Tag();
        $php->name ="PHP";
        $php->second_name ="php";
        $php->save();

        $laravel = new Tag();
        $laravel->name ="Laravel";
        $laravel->second_name ="laravel";
        $laravel->save();

        $vue = new Tag();
        $vue->name ="Vue Js";
        $vue->second_name ="vue js";
        $vue->save();

        $react = new Tag();
        $react->name ="React Js";
        $react->second_name ="react js";
        $react->save();


       $tags=[
           $php->id,
           $laravel->id,
           $vue->id,
           $react->id,
           ];
        foreach (Blog::all() as $blog){
            shuffle($tags);
         for ($i=0;$i ,rand(0,count($tags)-1);$i++)
         {
             $blog->tags()->detach($tags[$i]);
             $blog->tags()->attach($tags[$i]);
         }
        }

    }
}

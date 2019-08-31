<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use Carbon\Carbon;
class BlogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blogs')->truncate();


        $faker=Factory::create();
        $date=Carbon::create(2019, 7 ,11,8);
        $blogs=[];
        for ($i=1;$i<=10;$i++){
            $createdDate=clone ($date);
            $publishedDate=clone ($date);
           $date->addDay(1);
            $post_photo="post_image_".rand(1,5).".jpg";
            $blogs[]=[
                'user_id'=>rand(1,3),
               // 'category_id'=>rand(1,10),
                'view_count'=>rand(1,10),
                'post_tittle'=>$faker->sentence(rand(8,12)),
                'excerpt'=>$faker->text(rand(250,300)),
                'post_descripition'=>$faker->paragraph(rand(10,15),true),
                'slug'=>$faker->slug(),
                'post_photo'=>rand(0,1)==1? $post_photo:Null,
                'created_at'=> $createdDate,
                'updated_at'=> $createdDate,
                'published_at'=> $i>5 ? $publishedDate :(rand(0,1)==0 ? Null :$publishedDate->addDay($i + 4) )
            ];
        }
        DB::table('blogs')->insert($blogs);
    }
}

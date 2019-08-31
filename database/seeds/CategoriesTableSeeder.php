<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([

        [
            'title'=>'Web Programming',
            'slug'=>'Web Programming'
        ],
            [
                'title'=>'Internet',
                'slug'=>'Internet'
            ],
            [
                'title'=>'Social Media',
                'slug'=>'Social Media'
            ],
            [
                'title'=>'Web Design',
                'slug'=>'Web Design'
            ],
            [
                'title'=>'Photography',
                'slug'=>'Photography',
            ],
        ]);

        for ($blogs_id=1;$blogs_id<=10;$blogs_id++){
            $category_id=rand(1,5);
            DB::table('blogs')
                ->where('id',$blogs_id)
                ->update(['category_id'=> $category_id]);

        }

    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tags');
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('second_name')->unique();
            $table->timestamps();
        });
        Schema::dropIfExists('blog_tag');
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->integer('blog_id');
            $table->integer('tag_id');
           // $table->primary('blog_id','tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_tag');
        Schema::dropIfExists('tags');
    }
}

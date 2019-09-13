<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('website')->nullable();
            $table->string('facebook-link')->nullable();
            $table->string('youtube-link')->nullable();
            $table->string('twitter-link')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('register')->default(true);
            $table->boolean('comment')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

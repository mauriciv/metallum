<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bands', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('metallumId');
            $table->string('url');
            $table->string('logoUrl')->nullable();
            $table->string('logoLocalPath')->nullable();
            $table->string('photoUrl')->nullable();
            $table->string('photoLocalPath')->nullable();
            $table->string('countryOfOrigin');
            $table->string('name');
            $table->string('location');
            $table->string('status');
            $table->integer('formedIn');
            $table->string('genre');
            $table->string('lyricalThemes');
            $table->string('currentLabel');
            $table->string('yearsActive');
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
        Schema::dropIfExists('bands');
    }
}

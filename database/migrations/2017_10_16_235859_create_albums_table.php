<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('metallumId');
            $table->unsignedInteger('bandMetallumId');
            $table->string('name');
            $table->string('url');
            $table->string('artworkUrl')->nullable();
            $table->string('artworkLocalPath')->nullable();
            $table->string('type');
            $table->string('format');
            $table->string('label');
            $table->string('releaseDate')->nullable();
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
        Schema::dropIfExists('albums');
    }
}

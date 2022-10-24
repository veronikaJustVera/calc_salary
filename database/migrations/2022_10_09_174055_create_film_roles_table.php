<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('film_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->timestamps();
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_roles');
    }
}

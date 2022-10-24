<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('film_role_id')->index();
            $table->date('date');
            $table->integer('salary')->unsigned();
            $table->timestamps();
            $table->foreign('film_role_id')->references('id')->on('film_roles')->onDelete('cascade');
            $table->unique(['film_role_id', 'date', 'salary']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}

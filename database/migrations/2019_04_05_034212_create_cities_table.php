<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            //$table->smallInteger('indicative')->nullable();
            $table->string('lat', 13)->nullable();
            $table->string('lng', 13)->nullable();
            $table->string('slug', 45);
            $table->text('description', 1000)->nullable();
            $table->text('meta_keywords', 1000)->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->unsignedInteger('departament_id');
            $table->foreign('departament_id')->references('id')->on('departaments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cities');
        Schema::enableForeignKeyConstraints();
    }
}

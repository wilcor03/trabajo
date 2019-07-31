<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentEmployerOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
          Schema::create('departament_employer_offer', function (Blueprint $table) {

            $table->unsignedBigInteger('employer_offer_id')
              ->foreign('employer_offer_id')->references('id')->on('employer_offers')
              ->onDelete('cascade');

            $table->unsignedBigInteger('departament_id')
              ->foreign('departament_id')->references('id')->on('departaments')
              ->onDelete('cascade');
          });
        Schema::enableForeignKeyConstraints();  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
          Schema::dropIfExists('departament_employer_offer');
        Schema::enableForeignKeyConstraints();  
    }
}

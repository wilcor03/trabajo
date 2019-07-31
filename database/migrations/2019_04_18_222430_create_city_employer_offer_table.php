<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityEmployerOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::disableForeignKeyConstraints();
        Schema::create('city_employer_offer', function (Blueprint $table) {

          $table->unsignedInteger('employer_offer_id')        
            ->foreign('employer_offer_id')->references('id')->on('employer_offers')
            ->onDelete('cascade')
            ->onUpdate('cascade');

          $table->unsignedInteger('city_id')
            ->foreign('city_id')->references('id')->on('cities')
            ->onDelete('cascade')
            ->onUpdate('cascade');
          
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
        Schema::dropIfExists('city_employer_offer');
      Schema::enableForeignKeyConstraints();  
    }
}

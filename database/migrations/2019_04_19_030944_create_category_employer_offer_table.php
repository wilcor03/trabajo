<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryEmployerOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
      Schema::create('category_employer_offer', function (Blueprint $table) {
        $table->unsignedBigInteger('employer_offer_id')
          ->foreign('employer_offer_id')
          ->references('id')->on('employer_offers')
          ->onDelete('cascade')
          ->onUpdate('cascade');   

        $table->unsignedInteger('category_id')
          ->foreign('category_id')->references('id')->on('categories')
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
      Schema::dropIfExists('category_employer_offer');       
    }
}

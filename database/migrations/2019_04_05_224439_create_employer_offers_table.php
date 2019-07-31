<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerOffersTable extends Migration
{    
  public function up()
  {
    Schema::create('employer_offers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('vacancyName', 255);
      $table->text('description');            
      $table->date('publicationStart');
      $table->date('publicationEnd');            
      $table->unsignedTinyInteger('contractType');
      $table->string('contactEmail', 45)->nullable();
      $table->bigInteger('contactPhone')->nullable();      
      $table->bigInteger('contactCellPhone')->nullable();
      $table->unsignedInteger('salary')->nullable();
      $table->boolean('visible');
      $table->unsignedTinyInteger('coverage')->nullable();//1 nivel nacional
      $table->unsignedTinyInteger('state')->nullable();
      $table->timestamps();
    });
  }

  
  public function down()
  {
    Schema::dropIfExists('employer_offers');
  }
}

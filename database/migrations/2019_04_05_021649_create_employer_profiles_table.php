<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('employer_profiles', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('socialReason', 200);
        $table->tinyInteger('docType');
        $table->bigInteger('doc');
        $table->tinyInteger('dv')->nullable();
        $table->bigInteger('phone')->nullable();
        $table->bigInteger('celPhone')->nullable();
        $table->string('email', 100)->nullable();
        $table->unsignedBigInteger('city_id')
            ->foreign('city_id')->references('id')->on('cities')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        $table->unsignedBigInteger('user_id')
                ->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::disableForeignKeyConstraints();     
          Schema::dropIfExists('employer_profiles');
        Schema::enableForeignKeyConstraints();
    }
}

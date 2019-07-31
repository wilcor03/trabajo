<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityIdFieldInEmployeeProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('employee_profiles', function (Blueprint $table) {          
          $table->unsignedInteger('city_id');
          $table->foreign('city_id')->references('id')->on('cities')
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
        Schema::table('employee_profiles', function (Blueprint $table) {
            //
        });
    }
}

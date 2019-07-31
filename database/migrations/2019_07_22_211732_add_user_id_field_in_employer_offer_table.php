<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdFieldInEmployerOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('employer_offers', function (Blueprint $table) {
          $table->unsignedBigInteger('user_id');          
          $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //$table->dropForeign('employer_offers_user_id_foreign');
            //$table->dropColumn('user_id');
        });
        //Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employer_offers', function (Blueprint $table) {          
          $table->dropColumn('user_id');
        });
    }
}

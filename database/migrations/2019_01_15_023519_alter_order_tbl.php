<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    	
    	Schema::table('order', function (Blueprint $table) {
    		$table->dropColumn('status');
        });
    	
    	Schema::table('order', function (Blueprint $table) {
    		$table->string('status')->after('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

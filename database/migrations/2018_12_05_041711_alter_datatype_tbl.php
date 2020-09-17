<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDatatypeTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	
    	Schema::table('product', function (Blueprint $table) {
    		$table->dropColumn('sale_price');
        });
    	
    	Schema::table('product', function (Blueprint $table) {
    		$table->double('sale_price', 9, 2)->after('is_sale');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
   		Schema::table('product', function (Blueprint $table) {
    		$table->dropColumn('sale_price');
        });
		
    }
}

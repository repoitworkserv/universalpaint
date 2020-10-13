<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDiscountTypeToProductTbl extends Migration
{
    // public function __construct()
    // {
    //     DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    // }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('product', function (Blueprint $table) {
        	$table->enum('discount_type', ['fix', 'percentage'])->after('discount');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

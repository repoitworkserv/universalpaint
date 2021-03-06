<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPoductUserPriceTable extends Migration
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
        // Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        Schema::table('product_user_price', function (Blueprint $table) {
            DB::statement("ALTER TABLE `product_user_price` CHANGE `discount_type` `discount_type` ENUM('fix', 'percentage')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_user_price', function (Blueprint $table) {
            //
        });
    }
}

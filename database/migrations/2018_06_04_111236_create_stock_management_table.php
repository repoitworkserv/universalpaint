<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_management', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('product_code');
            $table->date('expiry_date');
            $table->string('serial_batch');
            $table->integer('quantity');
            $table->enum('stock_type', ['stock_in', 'stock_out']);
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
        Schema::drop('stock_management');
    }
}

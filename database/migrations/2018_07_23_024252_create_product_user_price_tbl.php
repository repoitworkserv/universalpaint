<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductUserPriceTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user_price', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('product_id');
			$table->integer('user_types_id');
			$table->float('price', 13, 2);
			$table->string('discount_type');
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
        Schema::drop('product_user_price');
    }
}

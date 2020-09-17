<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingDimensionTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_dimension', function (Blueprint $table) {
            $table->increments('id');
			$table->string('size');
			$table->double('length', 8, 2);
			$table->double('width', 8, 2);
			$table->double('height', 8, 2);
			$table->double('weight', 8, 2);
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
        Schema::drop('shipping_dimension');
    }
}

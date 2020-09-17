<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->string('fullname');
			$table->string('mobile_num');
			$table->string('no_bldg_st_name');
			$table->string('brgy');
			$table->string('city_municipality');
			$table->string('province');
			$table->string('other_notes');
			$table->integer('is_billing');
			$table->integer('is_shipping');
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
        Schema::drop('user_address');
    }
}

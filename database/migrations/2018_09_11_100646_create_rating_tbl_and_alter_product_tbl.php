<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTblAndAlterProductTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('product_reviews_and_rating', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->integer('product_id')->comment('product_id where parent id = 0');
			$table->string('title');
			$table->string('reviews');
			$table->integer('rate');
			$table->integer('is_anonymous');
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
        Schema::drop('product_reviews_and_rating');
    }
}

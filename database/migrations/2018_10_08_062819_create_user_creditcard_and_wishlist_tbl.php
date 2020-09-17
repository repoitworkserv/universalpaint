<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCreditcardAndWishlistTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('user_creditcards', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->string('type');
			$table->string('number');
			$table->string('holder');
			$table->date('expiry_date');
			$table->timestamps();
		});
		
		Schema::create('user_wishlist', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
			$table->integer('product_id');
			$table->timestamps();
		});
		
		Schema::table('settings', function(Blueprint $table) {
           $table->string('delivery_and_order_email')->after('email_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_creditcards');
		Schema::drop('user_wishlist');
    }
}

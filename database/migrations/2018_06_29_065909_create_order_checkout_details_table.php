<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCheckoutDetailsTable extends Migration
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
       Schema::create('order_checkout_details', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('order_id');
			$table->enum('reference', ['billing', 'shipping']);
            $table->string('lot_house_no');
            $table->string('city');
			$table->string('province');
			$table->string('region');
			$table->string('lname');
			$table->string('fname');
			$table->string('mname');
			$table->date('birth_date');
			$table->string('contact_no');
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
        Schema::drop('order_checkout_details');
    }
}

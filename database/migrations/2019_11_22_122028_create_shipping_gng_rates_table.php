<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingGngRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_gng_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location');
            $table->double('below05kg');
            $table->double('below1kg');
            $table->double('below3kg');
            $table->double('below4kg');
            $table->double('below5kg');
            $table->double('below6kg');
            $table->double('below7kg');
            $table->double('below8kg');
            $table->double('below9kg');
            $table->double('below10kg');
            $table->double('below11kg');
            $table->double('below12kg');
            $table->double('below13kg');
            $table->double('below14kg');
            $table->double('below15kg');
            $table->double('below16kg');
            $table->double('below17kg');
            $table->double('below18kg');
            $table->double('below19kg');
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
        Schema::drop('shipping_gng_rates');
    }
}

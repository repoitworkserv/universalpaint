<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBrochuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_brochures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brochure_title');
            $table->string('brochure_image');
            $table->string('brochure_file');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return <void></void>
     */
    public function down()
    {
        Schema::drop('product_brochures');
    }
}

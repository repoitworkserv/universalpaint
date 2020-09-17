<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->integer('is_sale')->after('price');
            $table->integer('sale_price')->after('is_sale');
            $table->dateTime('promo_start')->after('sale_price');
            $table->dateTime('promo_end')->after('promo_start');
            $table->float('shipping_width', 8, 2)->after('promo_end');
            $table->float('shipping_length', 8, 2)->after('shipping_width');
            $table->float('shipping_height', 8, 2)->after('shipping_length');
            $table->float('shipping_weight', 8, 2)->after('shipping_height');
            $table->string('featured_image')->after('shipping_weight');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

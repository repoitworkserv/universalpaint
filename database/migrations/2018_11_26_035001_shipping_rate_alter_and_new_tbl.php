<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingRateAlterAndNewTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_rate', function (Blueprint $table) {
            $table->double('amount_medium')->after('amount');
            $table->double('amount_large')->after('amount_medium');
            $table->renameColumn('amount', 'amount_small');
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

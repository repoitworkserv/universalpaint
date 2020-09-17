<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('order_code')->after('id');
			$table->double('amount',9,2)->after('status');
			$table->double('amount_shipping',9,2)->after('amount');
			$table->double('amount_discount',9,2)->after('amount_shipping');
			$table->double('amount_total',9,2)->after('amount_shipping');
			$table->dropColumn('total_amount');
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

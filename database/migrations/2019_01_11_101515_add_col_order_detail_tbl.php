<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColOrderDetailTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_checkout_details', function (Blueprint $table) {
             $table->string('note')->after('contact_no');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_checkout_details', function (Blueprint $table) {
             $table->dropColumn('note');
         });
    }
}

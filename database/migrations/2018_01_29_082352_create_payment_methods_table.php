<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsTable extends Migration
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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('method', ['ipay88', 'paypal', 'bank_deposit']);
            $table->string('key');
            $table->string('value');
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
        Schema::drop('payment_methods');
    }
}

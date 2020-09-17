<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMasterRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->string('description')->after('name');
        });
        
        Schema::table('brand', function (Blueprint $table) {
            $table->string('description')->after('name');
        });

        Schema::table('attribute', function (Blueprint $table) {
            $table->string('description')->after('name');
        });

        Schema::table('variable', function (Blueprint $table) {
            $table->string('description')->after('name');
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

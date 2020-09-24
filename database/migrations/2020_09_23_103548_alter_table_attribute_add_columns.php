<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAttributeAddColumns extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute', function (Blueprint $table) {
             $table->string('r_attr')->nullable()->after('name');
             $table->string('g_attr')->nullable()->after('r_attr');
             $table->string('b_attr')->nullable()->after('g_attr');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute', function (Blueprint $table) {             
             $table->dropColumn('r_attr');
             $table->dropColumn('g_attr');
             $table->dropColumn('b_attr');
         });
    }
}

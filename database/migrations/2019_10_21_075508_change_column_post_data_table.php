<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnPostDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_data', function (Blueprint $table) {
            $table->boolean('displayed_title')->nullable()->change();
            $table->boolean('displayed_post_content')->nullable()->change();
            $table->boolean('displayed_button')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_data', function (Blueprint $table) {

        });
    }
}

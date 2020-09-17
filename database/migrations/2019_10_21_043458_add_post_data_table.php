<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_data', function (Blueprint $table) {
            $table->boolean('displayed_title')->after('post_title')->default(0);
            $table->boolean('displayed_post_content')->after('post_content')->default(0);
            $table->boolean('displayed_button')->after('featured_banner')->default(0);
            $table->string('button_link')->after('post_type');
            $table->string('button_name')->after('featured_image');
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
            //
        });
    }
}

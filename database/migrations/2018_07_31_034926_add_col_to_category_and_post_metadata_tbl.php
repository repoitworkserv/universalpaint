<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColToCategoryAndPostMetadataTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
		    $table->string('featured_img_banner')->after('featured_img');
		});
		Schema::table('post_metadata', function (Blueprint $table) {
		    $table->string('source_type')->after('meta_value');
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

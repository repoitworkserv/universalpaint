<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeaturedImageBackgroundCategoryTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('category', function (Blueprint $table) {
            $table->string('featured_img_bg')->after('featured_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('featured_img_bg');
        });
    }
}

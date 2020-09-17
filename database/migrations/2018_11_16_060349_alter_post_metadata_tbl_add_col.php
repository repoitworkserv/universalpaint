<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostMetadataTblAddCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_metadata', function (Blueprint $table) {
            $table->string('display_name')->after('source_type')->comment('UI display');
			$table->string('paste_lnk')->after('display_name')->comment('pasted_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_metadata', function (Blueprint $table) {
            $table->dropColumn('display_name');
			$table->dropColumn('paste_lnk');
        });
    }
}

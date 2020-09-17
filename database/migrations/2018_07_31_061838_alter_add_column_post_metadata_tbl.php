<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddColumnPostMetadataTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_metadata', function(Blueprint $table) {
            $table->renameColumn('post_id', 'source_id');
            $table->string('meta_type')->after('meta_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_metadata', function(Blueprint $table) {
            $table->renameColumn('source_id', 'post_id');
        });
    }
}

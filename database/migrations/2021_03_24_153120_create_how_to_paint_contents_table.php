<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHowToPaintContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('how_to_paint_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('how_to_paint_id')->nullable(false);
            $table->text('content')->nullable(false);
            $table->string('image')->nullable(true);
            $table->boolean('status')->nullable(false)->default(true);
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
        Schema::drop('how_to_paint_contents');
    }
}

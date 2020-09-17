<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColTabsDetailProductTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function(Blueprint $table) {
           
            $table->string('list_tab')->after('is_active');
			$table->string('howtousetab_details')->after('list_tab');
			$table->string('deliveryopt_tab_details')->after('howtousetab_details');
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

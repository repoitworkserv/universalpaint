<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShippingDimensionSeeder::class);
        DB::table('users')->insert([
            'role_id'       => 1,
            'customer_id'   => 'EZD0101',
            'name'          => 'Administrator',
            'email'         => 'admin@gng.com',
            'password'      => bcrypt('password'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('role')->insert([
            'role_name'     => 'Administrator',
            'permission'    => '1,2,3,4,5,6,7,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'role_name'     => 'Customer',
            'permission'    => '1,2,3,4,5,6,7,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
		
		DB::table('user_types')->insert([
            'name'     => 'Administrator',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],[
        	'name'     => 'Regular',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('category')->insert([
            'name'          => 'Uncategorize',
            'description'   => 'Products that have no category will be categorize as uncategorize',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('brand')->insert([
            'name'          => 'Other',
            'description'   => 'Products that have no brand will be branded as other',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('post_data')->insert([
            'post_title' => 'Home',
            'post_name' => 'home',
            'post_type' => 'page',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

    }
}

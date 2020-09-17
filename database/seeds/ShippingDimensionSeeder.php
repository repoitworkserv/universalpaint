<?php

use Illuminate\Database\Seeder;

class ShippingDimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_dimension')->insert([
            'size' => 'small',
            'length' => '0',
            'width' => '0',
            'height' => '0',
            'weight' => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
        DB::table('shipping_dimension')->insert([
            'size' => 'medium',
            'length' => '0',
            'width' => '0',
            'height' => '0',
            'weight' => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
        DB::table('shipping_dimension')->insert([
            'size' => 'large',
            'length' => '0',
            'width' => '0',
            'height' => '0',
            'weight' => '0',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);
    }
}

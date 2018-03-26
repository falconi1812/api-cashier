<?php

use Illuminate\Database\Seeder;

class TypeLocationPerProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_per_type_location')->insert([
          ['id' => 1, 'type_id' => 1, 'product_id' => 1],
          ['id' => 1, 'type_id' => 1, 'product_id' => 2],
          ['id' => 1, 'type_id' => 1, 'product_id' => 3],
          ['id' => 1, 'type_id' => 1, 'product_id' => 4],
          ['id' => 1, 'type_id' => 1, 'product_id' => 5],
          ['id' => 1, 'type_id' => 1, 'product_id' => 6],
          ['id' => 1, 'type_id' => 1, 'product_id' => 7],
          ['id' => 1, 'type_id' => 1, 'product_id' => 8],
          ['id' => 1, 'type_id' => 1, 'product_id' => 9],
          ['id' => 1, 'type_id' => 1, 'product_id' => 10],
          ['id' => 1, 'type_id' => 1, 'product_id' => 11]
        ]);
    }
}

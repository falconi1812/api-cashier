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
          ['id' => 2, 'type_id' => 1, 'product_id' => 2],
          ['id' => 3, 'type_id' => 1, 'product_id' => 3],
          ['id' => 4, 'type_id' => 1, 'product_id' => 4],
          ['id' => 5, 'type_id' => 1, 'product_id' => 5],
          ['id' => 6, 'type_id' => 1, 'product_id' => 6],
          ['id' => 7, 'type_id' => 1, 'product_id' => 7],
          ['id' => 8, 'type_id' => 1, 'product_id' => 8],
          ['id' => 9, 'type_id' => 1, 'product_id' => 9],
          ['id' => 10, 'type_id' => 1, 'product_id' => 10],
          ['id' => 11, 'type_id' => 1, 'product_id' => 11]
        ]);
    }
}

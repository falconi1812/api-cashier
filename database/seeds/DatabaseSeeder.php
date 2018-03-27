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
         $this->call(TypeLocationPerProductTableSeeder::class);
         $this->call(TerrainTableSeeder::class);
         $this->call(TypeTableSeeder::class);
         $this->call(IconsTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         $this->call(TypePaymentTableSeeder::class);
    }
}

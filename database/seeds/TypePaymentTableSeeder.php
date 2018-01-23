<?php

use Illuminate\Database\Seeder;

class TypePaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('type_payment')->insert([
        [
          'id' => 1,
          'name' => 'card'
        ],
        [
          'id' => 2,
          'name' => 'cash'
        ]
      ]);
    }
}

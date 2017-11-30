<?php

use Illuminate\Database\Seeder;

class IconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('icons')->insert([
        [
          'id' => 1,
          'name' => 'male'
        ],
        [
          'id' => 2,
          'name' => 'child'
        ],
        [
          'id' => 3,
          'name' => 'th-large'
        ],
        [
          'id' => 4,
          'name' => 'th'
        ],
        [
          'id' => 5,
          'name' => 'paw'
        ],
        [
          'id' => 6,
          'name' => 'user-secret'
        ],
        [
          'id' => 7,
          'name' => 'beer'
        ],
        [
          'id' => 8,
          'name' => 'cutlery'
        ],
        [
          'id' => 9,
          'name' => 'keyboard-o'
        ]
      ]);
    }
}

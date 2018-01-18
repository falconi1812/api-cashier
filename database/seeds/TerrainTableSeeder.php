<?php

use Illuminate\Database\Seeder;

class TerrainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terrain')->insert(
          [
            'id' => 1,
            'name' => 'Terrain P'
          ],
          [
            'id' => 2,
            'name' => 'Terrain A'
          ],
          [
            'id' => 3,
            'name' => 'Terrain S'
          ]
      );
    }
}

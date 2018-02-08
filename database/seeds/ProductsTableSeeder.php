<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('products')->insert([
        [
          'id' => 1,
          'name' => 'Adulte Smart',
          'price' => 60,
          'icon_id' => 728
        ],
        [
          'id' => 2,
          'name' => 'Adulte Deluxe',
          'price' => 85,
          'icon_id' => 733
        ],
        [
          'id' => 3,
          'name' => 'Enfant',
          'price' => 35,
          'icon_id' => 154
        ],
        [
          'id' => 4,
          'name' => 'Arcs',
          'price' => 50,
          'icon_id' => 422
        ],
        [
          'id' => 5,
          'name' => 'Carton Supplémentaire',
          'price' => 80,
          'icon_id' => 215
        ],
        [
          'id' => 6,
          'name' => 'Sachet Supplémentaire Adulte',
          'price' => 30,
          'icon_id' => 156
        ],
        [
          'id' => 7,
          'name' => 'Sachet Supplémentaire Enfants',
          'price' => 20,
          'icon_id' => 159
        ],
        [
          'id' => 8,
          'name' => 'Costume',
          'price' => 40,
          'icon_id' => 734
        ],
        [
          'id' => 9,
          'name' => 'Combinaison Jetable',
          'price' => 8,
          'icon_id' => 732
        ],
        [
          'id' => 10,
          'name' => 'Bouchons De Canon',
          'price' => 5,
          'icon_id' => 69
        ],
        [
          'id' => 11,
          'name' => 'Pin Protection',
          'price' => 3,
          'icon_id' => 638
        ]
      ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // create 500 random user

    \App\Models\User::factory(500)->create();
    // \App\Models\Address::factory(500)->create();
    //\App\Models\Product::factory(1500)->create();
    //  \App\Models\Image::factory(3500)->create();
    // \App\Models\Review::factory(1500)->create();
    //\App\Models\Category::factory(50)->create();

     // \App\Models\Tag::factory(150)->create();
    // \App\Models\Ticket::factory(150)->create();


  }
}

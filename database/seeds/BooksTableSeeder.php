<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $employCode = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Book::class)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($employCode)
            ]);
        }
    }
}


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
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        factory(App\Model\Book::class, 15)->create([
            'category_id' => $faker->randomElement($categoryId),
            'from_person' => $faker->randomElement($userId)
        ]);
    }
}

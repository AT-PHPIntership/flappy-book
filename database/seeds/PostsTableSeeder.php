<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('users')->pluck('id')->toArray();
        $bookId = DB::table('books')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Post::class)->create([
                'user_id' => $faker->randomElement($userId),
                'book_id' => $faker->randomElement($bookId)
            ]);
        }
    }
}

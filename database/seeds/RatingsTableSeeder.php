<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postId = DB::table('posts')->where('status', 2)->pluck('id')->toArray();
        $bookId = DB::table('books')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i <= 15; $i++) {
            factory(App\Model\Rating::class)->create([
                'post_id' => $faker->randomElement($postId),
                'book_id' => $faker->randomElement($bookId)
            ]);
        }
    }
}

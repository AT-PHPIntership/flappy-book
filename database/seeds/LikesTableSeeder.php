<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postId = DB::table('posts')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        for($i = 0; $i <= 15; $i++) {
            factory(App\Model\Like::class)->create([
                'post_id' => $faker->randomElement($postId),
                'user_id' => $faker->randomElement($userId)
            ]);
        }
    }
}

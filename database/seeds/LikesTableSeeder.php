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
        factory(App\Model\Like::class, 15)->create([
            'post_id' => $faker->randomElement($postId),
            'user_id' => $faker->randomElement($userId)
        ]);
    }
}

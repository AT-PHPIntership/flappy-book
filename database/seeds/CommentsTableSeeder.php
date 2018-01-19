<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        for($i = 0; $i <= 15; $i++) {
            factory(App\Model\Comment::class)->create([
                'user_id' => $faker->randomElement($userId)
            ]);
        }
    }
}

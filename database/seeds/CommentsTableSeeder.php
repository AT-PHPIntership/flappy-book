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
        Model::unguard();
        $userId = DB::table('users')->pluck('id')->toArray();
        $faker = Faker::create();
        for ($i = 1; $i <= 15; $i++) {
            factory(App\Model\Comment::class, 1)->create([
                'user_id' => $faker->randomElement($userId)
            ]);
        }
        Model::reguard();
    }
}

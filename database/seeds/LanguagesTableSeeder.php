<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $numberLanguages = count(App\Model\Language::LANGUAGES);
        for ($i=0; $i < $numberLanguages; $i++) {
            factory(App\Model\Language::class)->create([
                'language' => $faker->unique()->randomElement(App\Model\Language::LANGUAGES),
            ]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
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
        foreach (App\Model\Language::LANGUAGES as $language) {
            factory(App\Model\Language::class)->create([
                'language' => $language,
            ]);
        }
    }
}

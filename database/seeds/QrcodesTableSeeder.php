<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class QrcodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookId = DB::table('books')->pluck('id')->toArray();
        $faker = Faker::create();
        foreach ($bookId as $id) {
            factory(App\Model\Qrcode::class, 1)->create([
                'book_id' => $id
            ]);
        }
    }
}


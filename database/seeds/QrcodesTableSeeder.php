<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;

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
        $numberRecord = count($bookId);
        $faker = Faker::create();
        for ($i = 0; $i <= $numberRecord - 1; $i++) {
            factory(App\Model\Qrcode::class)->create([
                'book_id' => $faker->unique()->randomElement($bookId)
            ]);
        }
    }
}

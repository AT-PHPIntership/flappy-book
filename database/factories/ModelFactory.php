<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Model\Category::class, function (Faker $faker) {
      return [
          'title' => $faker->name,
      ];
  });
$factory->define(App\Model\Book::class, function (Faker $faker) {
      return [
          'qrcode' => $faker->ean13,
          'title' => $faker->name,
          'description' => $faker->text,
          'year' => $faker->year(),
          'author' => $faker->name,
          'price' => $faker->numberBetween($min = 1000, $max = 9000),
          'unit' => $faker->randomElement(['VND', '$', '¥', '€']),
          'picture' => $faker->image,
          'from_person' => $faker->name,
          'total_rating' => $faker->numberBetween($min = 1, $max = 20),
          'rating' => $faker->numberBetween($min = 1, $max = 5),
          'is_printed' => $faker->numberBetween($min = 0, $max = 1),
      ];
  });
$factory->define(App\Model\Borrow::class, function (Faker $faker) {
      return [
          'from_date' => $faker->datetime,
          'to_date' => $faker->datetime,
          'status' => $faker->numberBetween($min = 0, $max = 1),
      ];
  });
$factory->define(App\Model\Post::class, function (Faker $faker) {
    return [
        'content' => $faker->text,
        'is_findbook' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
$factory->define(App\Model\Comment::class, function (Faker $faker) {
    return [
        // 'parent_id' => $faker->numberBetween($min = 1, $max = 10,),
        'commentable_id' => $faker->numberBetween($min = 1, $max = 10),
        'commentable_type' => $faker->randomElement(['Book', 'Post']),
        'comment' => $faker->text,
    ];
});
$factory->define(App\Model\Like::class, function (Faker $faker) {
    return [

    ];
});

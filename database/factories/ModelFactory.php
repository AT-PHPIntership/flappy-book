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
        'price' => $faker->numberBetween(1000,9000),
        'unit' => $faker->randomElement([\App\Model\Book::TYPE_VND, \App\Model\Book::TYPE_DOLAR,\App\Model\Book::TYPE_YEN, \App\Model\Book::TYPE_EURO]),
        'picture' => $faker->image,
        'from_person' => $faker->name,
        'total_rating' => $faker->numberBetween(1,20),
        'rating' => $faker->numberBetween(1,5),
        'is_printed' => $faker->numberBetween(0,1),
    ];
});
$factory->define(App\Model\Borrow::class, function (Faker $faker) {
    return [
        'from_date' => $faker->datetime,
        'to_date' => $faker->datetime,
        'status' => $faker->numberBetween(0,1),
    ];
});
$factory->define(App\Model\Post::class, function (Faker $faker) {
    return [
        'content' => $faker->text,
        'is_findbook' => $faker->numberBetween(0,1),
    ];
});
$factory->define(App\Model\Comment::class, function (Faker $faker) {
    return [
        'commentable_id' => $faker->numberBetween(1,10),
        'commentable_type' => $faker->randomElement(['Book', 'Post']),
        'comment' => $faker->text,
    ];
});
$factory->define(App\Model\Like::class, function (Faker $faker) {
    return [

    ];
});
$factory->define(App\Model\User::class, function (Faker $faker) {
    return [
        'employ_code' => 'AT'.$faker->numberBetween(1000,9999),
        'name' => $faker->name,
        'email' => $faker->email,
        'team' => $faker->randomElement([\App\Model\User::TEAM_PHP, \App\Model\User::TEAM_IOS,\App\Model\User::TEAM_ANDROID, \App\Model\User::TEAM_SA, \App\Model\User::TEAM_BO]),
        'avatar_url' => $faker->image,
        'is_admin' => $faker->numberBetween(0,1),
    ];
});

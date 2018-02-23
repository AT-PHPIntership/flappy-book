<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\Category;
use App\Model\User;
use App\Model\Book;
use DB;

class BookTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test response Api detail book
     *
     * @return void
     */
    public function testDetailBook()
    {
        $this->makeData(1);
        $response = $this->get('/api/books/1');
        $response->assertStatus(200)
                ->assertJson([
                    'meta' => [
                        'status' => 'Successfully',
                    ],
                ])
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'title',
                        'category_id',
                        'description',
                        'language',
                        'rating',
                        'total_rating',
                        'picture',
                        'author',
                        'price',
                        'unit',
                        'year',
                        'page_number',
                        'status',
                        'user_id',
                        'donator',
                        'category',
                    ]
                ]);
    }

    /**
     * Test response Api get book does not exist
     *
     * @return void
     */
    public function testGetBookDoesNotExist()
    {
        $response = $this->get('/api/books/0');
        $response->assertStatus(404)
                ->assertJson([
                    'meta' => [
                        'status' => 'Failed'
                    ],
                ]);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {   
        factory(Category::class)->create();
        factory(User::class)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($userId)
            ]);
        }
    }
}

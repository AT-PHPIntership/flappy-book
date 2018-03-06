<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\Category;
use App\Model\User;
use App\Model\Book;
use App\Model\Language;
use DB;

class ApiDetailBookTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Receive status code 200 when get detail book success.
     *
     * @return void
     */
    public function testStatusCodeSuccess()
    {
        $this->makeData(1);
        $response = $this->json('GET', '/api/books/1');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureTopBooksReview(){
        return [
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                'id',
                'title',
                'category_id',
                'description',
                'language_id',
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
                'category' => [
                    'id',
                    'title'
                ],
                'language' => [
                    'id',
                    'language'
                ]
            ],
        ];
    }

    /**
     * Test structure of json response.
     *
     * @return void
     */
    public function testJsonTopBooksReviewStructure(){
        $this->makeData(1);
        $response = $this->json('GET', '/api/books/1');
        $response->assertJsonStructure($this->jsonStructureTopBooksReview());
    }

    /**
     * Test response Api get book does not exist
     *
     * @return void
     */
    public function testGetBookDoesNotExist()
    {
        $response = $this->get('/api/books/0');
        $response->assertStatus(Response::HTTP_NOT_FOUND)
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
        factory(Language::class)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $languageId = DB::table('languages')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class)->create([
                'category_id' => $faker->randomElement($categoryId),
                'language_id' => $faker->randomElement($languageId),
                'from_person' => $faker->randomElement($userId)
                ]);
        }
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\Category;
use App\Model\User;
use App\Model\Book;
use DB;
use Illuminate\Http\Response;

class ApiTopBooksReviewTest extends TestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 15;
    
    /**
     * Receive status code 200 when get top books review success.
     *
     * @return void
     */
    public function testStatusCodeSuccess()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books/top-review');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureTopBooksReview()
    {
        return [
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                [
                    'id',
                    'title',
                    'rating',
                    'total_rating',
                    'picture',
                ]
            ]    
        ];
    }

    /**
     * Test structure of json response.
     *
     * @return void
     */
    public function testJsonTopBooksReviewStructure()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books/top-review');
        $response->assertJsonStructure($this->jsonStructureTopBooksReview());
    }

    /**
     * Test compare database
     * 
     * @return void
     */
    public function testCompareDatabase()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books/top-review');
        $data = json_decode($response->getContent());
        $imagePath = explode(url('/') . '/' . config('define.books.folder_store_books'), $data->data[0]->picture)[1];
        $arrayCompare = [
            'id' => $data->data[0]->id,
            'title' => $data->data[0]->title,
            'rating' => $data->data[0]->rating,
            'total_rating' => $data->data[0]->total_rating,
            'picture' => $imagePath,
        ];
        $this->assertDatabaseHas('books', $arrayCompare);
        $this->assertTrue(count($data->data) === config('define.books.amount_top_books_review'));
    }

    /**
     * Test structure of json when empty books.
     *
     * @return void
     */
    public function testEmptyBooks()
    {
        $response = $this->json('GET', '/api/books/top-review');   
        $response->assertJson([
            'data' => []
        ]);
    }

    /**
     * Make data for test
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

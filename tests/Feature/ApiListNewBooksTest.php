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
use App\Model\Language;
use DB;
use Illuminate\Http\Response;

class ApiListNewBooksTest extends TestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 25;
    
    /**
     * Receive status code 200 when get list new books success.
     *
     * @return void
     */
    public function testStatusCodeSuccess()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureListNewBooks()
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
                    'picture',
                    'total_rating',
                    'rating',
                ]
            ]
        ];
    }

    /**
     * Test structure of json response.
     *
     * @return void
     */
    public function testJsonListNewBooksStructure()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books');
        $response->assertJsonStructure($this->jsonStructureListNewBooks());
    }

    /**
     * Test compare database
     *
     * @return void
     */
    public function testCompareDatabase()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books');
        $data = json_decode($response->getContent());
        $imagePath = explode(url('/') . '/' . config('define.books.folder_store_books'), $data->data[0]->picture)[1];
        $arrayCompare = [
            'id' => $data->data[0]->id,
            'title' => $data->data[0]->title,
            'picture' => $imagePath,
            'total_rating' => $data->data[0]->total_rating,
            'rating' => $data->data[0]->rating,
        ];
        $this->assertDatabaseHas('books', $arrayCompare);
    }

    /**
     * Test structure of json when empty books.
     *
     * @return void
     */
    public function testEmptyBooks()
    {
        $response = $this->json('GET', '/api/books');
        $response->assertJson([
            'data' => []
        ]);
    }

    /**
     * Test result pagination.
     *
     * @return void
     */
    public function testGetPaginationResult()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', 'api/books?page=2');
        $response->assertJson([
            'pagination' => [
                'total' => self::NUMBER_RECORD_CREATE,
                'per_page' => config('define.books.limit_item'),
                'current_page' => 2,
                'total_pages' => 2,
            ]
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Make data for test
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create();
        $language = factory(Language::class)->create([
            'language' =>  $faker->randomElement(Language::LANGUAGES),
        ]);
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class)->create([
                'category_id' => $category->id,
                'language_id' => $language->id,
                'from_person' => $user->employ_code,
            ]);
        }
    }
}

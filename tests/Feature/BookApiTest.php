<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Qrcode;

class BookApiTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * Test status code
     *
     * @return void
     */
    public function testStatusCodeListBooks()
    {
        $response = $this->get('api/books');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return json structure of list books
     *
     * @return array
     */
    public function JsonStructureListBooks()
    {
        return [
            'data' => [
                [
                    'id',
                    'title',
                    'picture',
                    'total_rating'
                ]
            ],
            'meta' => [
                'message',
                'code'
            ],
            'current_page',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ];
    }
    /**
     * Test compare structure of json.
     *
     * @return void
     */
    public function testJsonStructureListBooks()
    {
        $this->makeData(1);
        $response = $this->json('GET', '/api/books');
        $response->assertJsonStructure($this->JsonStructureListBooks());
    }

     /**
     * Test result pagination.
     *
     * @return void
     */
    public function testWithPaginationListBooks()
    {
        $this->makeData(21);
        $response = $this->json('GET', '/api/books' . '?page=2');
        $response->assertJson([
            'current_page' => 2,
            'per_page' => 20,
            'from' => 21,
            'to' => 21,
            'last_page' => 2,
            'next_page_url' => null
        ]);
    }

    /**
     * Test compare database.
     *
     * @return void
     */
    public function testCompareDatabaseListBooks()
    {
        $this->makeData(1);
        $response = $this->json('GET', '/api/books');
        $data = json_decode($response->getContent());
        $this->assertDatabaseHas('books', [
            'id' => $data->data[0]->id,
            'title' => $data->data[0]->title,
            'picture' => explode(request()->getSchemeAndHttpHost() .'/'. config('image.book.path'), $data->data[0]->picture)[1],
            'total_rating' => $data->data[0]->total_rating
        ]);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {   
        $faker = Faker::create();
        $userId = factory(User::class, 2)->create()->pluck('employ_code')->toArray();
        $categoryId = factory(Category::class, 2)->create()->pluck('id')->toArray();
        for ($i = 0; $i < $row - 1; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($userId)
            ]);
        }
        factory(Book::class, 1)->create([
            'title' => 'Java',
            'author' => 'Pytago',
            'category_id' => $faker->randomElement($categoryId),
            'from_person' => $faker->randomElement($userId)
        ]);
        $bookId = DB::table('books')->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            factory(Qrcode::class)->create([
                'book_id' => $faker->unique()->randomElement($bookId)
            ]);
        }
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
}

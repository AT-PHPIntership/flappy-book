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

class SearchBookApiTest extends TestCase
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
     * Test search books with correct name.
     *
     * @return void
     */
    public function testSearchBookCorrectName()
    {
        $this->makeData(1);
        $book = Book::first();
        $response = $this->json('GET', '/api/books?search='. $book->title);
        $response->assertJson([
            'data' => [
                [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'picture' => $book->picture,
                    'total_rating' => $book->total_rating
                ]
            ]
        ]);
    }

    /**
     * Test search books with correct author.
     *
     * @return void
     */
    public function testSearchBookCorrectAuthor()
    {
        $this->makeData(1);
        $book = Book::first();
        $response = $this->json('GET', '/api/books?search='. $book->author);
        $response->assertJson([
            'data' => [
                [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'picture' => $book->picture,
                    'total_rating' => $book->total_rating
                ]
            ]
        ]);
    }

    /**
     * Test search books with incorrect keyword.
     *
     * @return void
     */
    public function testSearchBookIncorrectKeyword()
    {
        $this->makeData(10);
        Book::select('*')->update(['title' => '1', 'author' => '1']);
        $response = $this->json('GET', '/api/books?search=0');
        $response->assertJson([
            'data' => []
        ]);
    }

    /**
     * Test search books without keyword.
     *
     * @return void
     */
    public function testSearchBookWithoutKeyword()
    {
        $this->makeData(10);
        $response = $this->json('GET', '/api/books?search=');
        $content = json_decode($response->getContent());
        $this->assertTrue(sizeof($content->data) === 10);
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
}

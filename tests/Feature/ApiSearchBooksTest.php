<?php

namespace Tests\Feature;

use App\Model\Book;
use App\Model\Category;
use App\Model\Language;
use App\Model\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApiSearchBooksTest extends TestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 5;

    /**
     * Receive status code 200 when search books success.
     *
     * @return void
     */
    public function testStatusCodeSuccess()
    {
        $response = $this->json('GET', '/api/books?category=1&borrow=0&title=abc&author=tg&language=1');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test get books with filter title
     *
     * @return void
     */
    public function testFilterFollowTitle()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        factory(Book::class)->create([
            'category_id' => 1,
            'language_id' => 1,
            'from_person' => 'AT0123',
            'title' => 'This is tha thu',
        ]);
        $response = $this->json('GET', '/api/books?title=tha thu');
        $response->assertSeeText('This is tha thu');
        $data = json_decode($response->getContent());
        $this->assertTrue(count($data->data) === 1);
    }

    /**
     * Test get books with filter author
     *
     * @return void
     */
    public function testFilterFollowAuhtor()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        factory(Book::class)->create([
            'category_id' => 1,
            'language_id' => 1,
            'from_person' => 'AT0123',
            'author' => 'Dao Thanh Minh',
        ]);
        $response = $this->json('GET', '/api/books?author=Minh');
        $data = json_decode($response->getContent());
        $this->assertTrue(count($data->data) === 1);
    }

    /**
     * Test get books with filter category
     *
     * @return void
     */
    public function testFilterFollowCategory()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $response = $this->json('GET', '/api/books?category=1');
        $data = json_decode($response->getContent());
        $this->assertTrue(count($data->data) === self::NUMBER_RECORD_CREATE);
    }

    /**
     * Test get books with filter borrow
     *
     * @return void
     */
    public function testFilterFollowBorrow()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        factory(Book::class)->create([
            'category_id' => 1,
            'language_id' => 1,
            'from_person' => 'AT0123',
            'status' => '0',
        ]);
        $response = $this->json('GET', '/api/books?borrow=0');
        $data = json_decode($response->getContent());
        $this->assertTrue(count($data->data) === 1);
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
        $user = factory(User::class)->create([
            'employ_code' => 'AT0123',
        ]);
        $language = factory(Language::class)->create([
            'language' => $faker->randomElement(Language::LANGUAGES),
        ]);
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class)->create([
                'category_id' => $category->id,
                'language_id' => $language->id,
                'from_person' => $user->employ_code,
                'status' => '1',
            ]);
        }
    }
}

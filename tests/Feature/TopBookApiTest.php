<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
use App\Model\User;
use App\Model\Category;
use App\Model\Borrow;
use App\Model\Book;
use Faker\Factory as Faker;

class TopBookApiTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * Receive status code 200 when get list top book.
     *
     * @return void
     */
    public function testStatusCodeInTopBookBorrow()
    {
        $response = $this->get('/api/books/top-borrow');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Return structure of json.
     *
     * @return array
     */
    public function jsonStructureTopBorrowBooks(){
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
	                'borrows_count'
            	]
        	], 
            "pagination" => [
            	[
			        "total",
			        "per_page",
			        "current_page",
			        "total_pages",
			        "links" => [
			            "prev",
			            "next"
		        	],
    			]
        	]
    	];	
    }

     /**
     * Test structure of json.
     *
     * @return void
     */
    public function testJsonTopBorrowStructure(){
        $this->makeData(1);
        dd(makeData(1));
        $response = $this->json('GET', '/api/books/top-borrow');
        $response->assertJsonStructure($this->jsonStructureTopBorrowBooks());
    }

    // /**
    //  * Test result pagination.
    //  *
    //  * @return void
    //  */
    // public function testWithPaginationTopBorrowBooks()
    // {
    //     $this->makeData(21);
    //     $response = $this->json('GET', '/api/books/top-borrow' . '?page=2');
    //     $response->assertJson([
    //             'current_page' => 2,
    //             'per_page' => 20,
    //             'from' => 21,
    //             'to' => 21,
    //             'last_page' => 2,
    //             'next_page_url' => null,
    //     ]);
    // }

    // /**
    //  * Test structure of json when empty top books.
    //  *
    //  * @return void
    //  */
    // public function testEmptyTopBorrowBooks(){
    //     $response = $this->json('GET', '/api/books/top-borrow');
    //     $response->assertJson([
    //         'data' => []
    //     ]);
    // }

    /**
     * A Data test for users, books and borrows
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        $users = factory(User::class, 4)->create();
        $userId = $users->pluck('id')->toArray();
        $employeeCode = $users->pluck('employ_code')->toArray();
        $categoryId = factory(Category::class, 2)->create()->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            $books[] = factory(Book::class)->create([
                'from_person' => $faker->randomElement($employeeCode),
                'category_id' => $faker->randomElement($categoryId),
            ]);
        }
        $bookId = array_pluck($books, 'id');
        for ($i = 0; $i < $row; $i++) {
            factory(Borrow::class)->create([
                'book_id' => $faker->randomElement($bookId),
                'user_id' => $faker->randomElement($userId),
                'status' => Borrow::BORROWING
            ]);
        }
    }
}

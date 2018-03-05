<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Faker\Factory as Faker;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Post;
use App\Model\Rating;

class ApiCreatePostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * List case for Test validate create Post
     *
     * @return array
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['status', '', '' , 'The status field is required.'],
            ['status', 'abc', 'abc', 'The selected status is invalid.'],
            ['content', '', Post::TYPE_REVIEW_BOOK, 'The content field is required.'],
            ['book_id', '', Post::TYPE_REVIEW_BOOK, 'The book id field is required.'],
            ['book_id', 'abc', Post::TYPE_REVIEW_BOOK, 'The selected book id is invalid.'],
            ['rating', '', Post::TYPE_REVIEW_BOOK, 'The rating field is required.'],
            ['rating', 'abc', Post::TYPE_REVIEW_BOOK, 'The rating must be a number.'],            
        ];
    }

    /**
     * Test validate for input
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateForInput($field, $content, $status, $message)
    {
        $this->withoutMiddleWare();

        $dataTest['status'] = $status;
        $dataTest[$field] = $content;

        $response = $this->post('api/posts', $dataTest);
        $response->assertJson([
            'error' => [
                'message' => [
                    $field => [
                        $message
                    ],
                ]
            ]
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * List case for Test create Post
     *
     * @return array
     */
    public function listCaseTestCreatePost()
    {
        return [
            [Post::TYPE_STATUS],
            [Post::TYPE_FIND_BOOK],
            [Post::TYPE_REVIEW_BOOK],
        ];
    }

    /**
     * Test create success
     *
     * @dataProvider listCaseTestCreatePost
     *
     * @return void
     */
    public function testCreatePostSuccess($status)
    {
        $this->withoutMiddleWare();
        $bookId = $this->makeData();
        $this->be(User::first());
        
        $dataTest = [
            'status' => $status,
            'content' => 'Content for comment',
            'book_id' => $bookId,
            'rating' => 4,
        ];
        $response = $this->post('api/posts', $dataTest);
        $response->assertJsonStructure([
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                'id',
                'user_id',
                'content',
                'status',
                'name',
                'team',
                'avatar_url',
                'is_admin',
                'picture',
                'title',
                'book_id',
                'rating',
                'likes',
                'created_at',
                'updated_at',
            ]
        ])->assertStatus(Response::HTTP_CREATED);
                
        $data = $response->baseResponse->getData(true)['data'];
        $post = array_only($data, ['id', 'content', 'status', 'created_at', 'updated_at']);
        
        $this->assertDatabaseHas('posts', $post);
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {   
        $faker = Faker::create();

        $categoryIds = factory(Category::class, 2)->create()->pluck('id')->toArray();

        $employeeCodes = factory(User::class, 2)->create()->pluck('employ_code')->toArray();

        $bookId = factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryIds),
            'from_person' => $faker->randomElement($employeeCodes)
        ])->id;

        return $bookId;
    }
}

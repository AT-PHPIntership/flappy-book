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
use App\Model\Comment;
use App\Model\Post;
use App\Model\Rating;

class ApiCreateCommentTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * List case for Test validate create Comment
     *
     * @return array
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['commentable_id', '', 'The commentable id field is required.'],
            ['commentable_id', 'abc', 'The commentable id must be an integer.'],            
            ['commentable_type', '', 'The commentable type field is required.'],
            ['commentable_type', 'abc', 'The selected commentable type is invalid.'],            
            ['comment', '','The comment field is required.'],          
        ];
    }

    /**
     * Test validate for input
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateForInput($field, $content, $message)
    {
        $this->withoutMiddleWare();

        $dataTest[$field] = $content;
        $response = $this->post('api/comments', $dataTest);
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
     * Test create success
     *
     * @return void
     */
    public function testCreatePostSuccess()
    {
        $this->withoutMiddleWare();
        $bookId = $this->makeData();
        $this->be(User::first());
        
        $dataTest = [
            'commentable_id' => $bookId,
            'commentable_type' => Comment::BOOK_TYPE,            
            'comment' => 'Content for comment',
        ];
        $response = $this->post('api/comments', $dataTest);
        $response->assertJsonStructure([
            'meta' => [
                'status',
                'code'
            ],
            'data' => [
                'id',
                'comment',
                'commentable_id',
                'commentable_type',
                'name',
                'team',
                'avatar_url',
                'is_admin',
                'parent_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]
        ])->assertStatus(200);
                
        $data = $response->baseResponse->getData(true)['data'];
        $comment = array_only($data, ['id', 'comment', 'commentable_id', 'commentable_type', 'created_at', 'updated_at']);

        $this->assertDatabaseHas('comments', $comment);
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

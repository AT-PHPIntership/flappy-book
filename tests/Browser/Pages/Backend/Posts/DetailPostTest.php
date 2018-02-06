<?php

namespace Tests\Browser\Pages\Backend\Posts;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Rating;
use App\Model\Comment;
use App\Model\Like;
use App\Model\Post;
use Faker\Factory as Faker;
use DB;

class DetailPostTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
       parent::setUp();

       $this->makeData();
    }

    /**
     * A Dusk test show link detail transfer to detail post page.
     *
     * @return void
     */
    public function testDetailPostStatus()
    {
        $this->browse(function (Browser $browser) {
            $post = $this->makeQueryDetailPost(1);
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/posts/1')
                ->assertSee('Detail post')
                ->assertSee('List comments')
                ->assertDontSee('Rating');

                $likes = $browser->text('ul.list-group-unbordered li:nth-child(2) a');
                $this->assertEquals($post->likes, $likes);
        });
    }

    /**
     * A Dusk test click link detail of find book status transfer to detail post page.
     *
     * @return void
     */
    public function testDetailPostFindBook()
    {
        $this->browse(function (Browser $browser) {
            $post = $this->makeQueryDetailPost(2);
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/posts/2')
                ->assertSee('Find book')
                ->assertSee('Detail post')
                ->assertSee('List comments')
                ->assertDontSee('Rating');

                $likes = $browser->text('ul.list-group-unbordered li:nth-child(2) a');
                $this->assertEquals($post->likes, $likes);
        });
    }

     /**
     * A Dusk test click link detail of review status transfer to detail post page.
     *
     * @return void
     */
    public function testDetailPostReviewBook()
    {
        $this->browse(function (Browser $browser) {
            $post = $this->makeQueryDetailPost(3);
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/posts/3')
                ->assertSee('Review')
                ->assertSee('Detail post')
                ->assertSee('List comments')
                ->assertSee('Book')
                ->assertSee('Rating');

            $rating = $browser->text('ul.list-group-unbordered li:nth-child(3) a');
            $likes = $browser->text('ul.list-group-unbordered li:nth-child(4) a');
            $this->assertEquals($post->rating, $rating);
            $this->assertEquals($post->likes, $likes);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();

        // Create categories
        $category = factory(Category::class)->create();
        
        // Create books
        $categoryId = $category->pluck('id')->toArray();
        $employCode = $this->user->employ_code;
        factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryId),
            'from_person' => $employCode,
        ]);

        // Create posts
        $userId = $this->user->id;
        for ($i = 0; $i < 3; $i++) {
            factory(Post::class)->create([
                'status'  => $i,
                'user_id' => $userId,
            ]);
        }

        // Create comments
        $postId = DB::table('posts')->pluck('id')->toArray();
        for ($i = 0; $i < 15; $i++) {
            factory(Comment::class)->create([
                'user_id' => $userId,
                'commentable_type' => 'post',
                'commentable_id' => $faker->randomElement($postId),
            ]);
        }

        // Create likes
        for ($i = 0; $i < 15; $i++) {
            factory(Like::class)->create([
                'post_id' => $faker->randomElement($postId),
                'user_id' => $userId,
            ]);
        }

        // Create rating
        $bookId = DB::table('books')->pluck('id')->toArray();
        factory(Rating::class)->create([
            'post_id' => '3',
            'book_id' => $faker->randomElement($bookId)
        ]);
    }

    public function makeQueryDetailPost($id)
    {
        $fields = [
            'posts.status',
            'ratings.rating',
            DB::raw('COUNT(likes.id) AS likes'),
        ];

        $post = Post::select($fields)
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->groupBy('posts.id', 'ratings.id')
                    ->findOrFail($id);

        return $post;
    }
}

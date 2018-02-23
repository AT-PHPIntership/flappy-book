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

    const NUMBER_RECORD_LIKE = 5;
    const RATING = 5;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
       parent::setUp();
    }

    /**
     * A Dusk test show link detail transfer to detail post page.
     *
     * @return void
     */
    public function testDetailPostStatus()
    {
        $this->makeData(0);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/posts/1')
                ->assertSee('Detail Post')
                ->assertSee('List comments')
                ->assertDontSee('Rating');

                $likes = $browser->text('ul.list-group-unbordered li:nth-child(2) a');
                $this->assertEquals(self::NUMBER_RECORD_LIKE, $likes);
        });
    }

    /**
     * A Dusk test click link detail of find book status transfer to detail post page.
     *
     * @return void
     */
    public function testDetailPostFindBook()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/posts/1')
                ->assertSee('Find book')
                ->assertSee('Detail Post')
                ->assertSee('List comments')
                ->assertDontSee('Rating');

                $likes = $browser->text('ul.list-group-unbordered li:nth-child(2) a');
                $this->assertEquals(self::NUMBER_RECORD_LIKE, $likes);
        });
    }

     /**
     * A Dusk test click link detail of review status transfer to detail post page.
     *
     * @return void
     */
    public function testDetailPostReviewBook()
    {
        $this->makeData(2);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->resize(1920, 1080)
                ->visit('/admin/posts/1')
                ->assertSee('Review')
                ->assertSee('Detail Post')
                ->assertSee('List comments')
                ->assertSee('Book')
                ->assertSee('Rating');

            $rating = $browser->text('ul.list-group-unbordered li:nth-child(3) a');
            $likes = $browser->text('ul.list-group-unbordered li:nth-child(4) a');
            $this->assertEquals(self::RATING, $rating);
            $this->assertEquals(self::NUMBER_RECORD_LIKE, $likes);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($status)
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
        factory(Post::class)->create([
            'status'  => $status,
            'user_id' => $userId,
        ]);

        // Create likes
        factory(Like::class, self::NUMBER_RECORD_LIKE)->create([
            'post_id' => 1,
            'user_id' => $userId,
        ]);

        // Create comments
        for ($i = 0; $i < 15; $i++) {
            factory(Comment::class)->create([
                'user_id' => $userId,
                'commentable_type' => 'post',
                'commentable_id' => 1,
            ]);
        }

        // Create rating
        $bookId = DB::table('books')->pluck('id')->toArray();
        factory(Rating::class)->create([
            'rating' => self::RATING,
            'post_id' => 1,
            'book_id' => $faker->randomElement($bookId)
        ]);
    }
}

<?php

namespace Tests\Browser\Pages\Backend\Dashboard;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Category;
use App\Model\Borrow;
use App\Model\Book;
use App\Model\Post;
use DB;
use Faker\Factory as Faker;

class DashboardPageTest extends DuskTestCase
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
    }

    /**
     * A Dusk test show view dashboard page.
     *
     * @return void
     */
    public function testSeeDashboardPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->clickLink('Dashboard')
                    ->assertPathIs('/admin')
                    ->assertSee('Dashboard');
        });
    }

    /**
     * A Dusk test show value.
     *
     * @return void
     */
    public function testValueOnPage()
    {
        $this->makeData(8);
        $linkNames = ['books', 'borrows', 'users', 'posts', 'categories'];
        $this->browse(function (Browser $browser) use($linkNames) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->clickLink('Dashboard')
                    ->assertSee('BOOKS')
                    ->assertSee('BORROWS')
                    ->assertSee('POSTS')
                    ->assertSee('CATEGORIES');
            foreach ($linkNames as $name) {
                $browser->assertSeeIn("#dashboard-$name .info-box-number", 8);
            }
        });
    }

    /**
     * Case test fot test connect page
     *
     * @return array
     */
    public function caseTestConnectPage()
    {
        return [
            [1, 'books',  'Books'],
            [2, 'borrows', 'Borrower'],
            [3, 'users', 'Users'],
            [4, 'posts', 'Posts'],
            [5, 'categories', 'Categories'],
           
        ];
    }

    /**
    * A Dusk test test connected Page.
    *
    * @dataProvider caseTestConnectPage
    *
    * @return void
    */
    public function testConnectPage($number, $link, $str) 
    {
        $this->makeData(10);
        $this->browse(function (Browser $browser) use ($number, $link, $str) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->click("#dashboard-$link a")
                    ->assertPathIs('/admin/'.$link)
                    ->assertSee('List '.$str);
        });
    }

    /**
     * A Data test for dashboard.
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create();
        $users = factory(User::class, $row -1 )->create();
        $userId = $users->pluck('id')->toArray();
        $employeeCode = $users->pluck('employ_code')->toArray();
        factory(Post::class, $row)->create([
            'user_id' => $faker->randomElement($userId)
        ]);
        $categoryId = factory(Category::class, $row)->create()->pluck('id')->toArray();
        $books = factory(Book::class, $row)->create([
            'from_person' => $faker->randomElement($employeeCode),
            'category_id' => $faker->randomElement($categoryId),
        ]);
        $bookId = $books->pluck('id')->toArray();
        factory(Borrow::class, $row)->create([
            'book_id' => $faker->randomElement($bookId),
            'user_id' => $faker->randomElement($userId),
            'status' => Borrow::BORROWING
        ]);
    }  
}
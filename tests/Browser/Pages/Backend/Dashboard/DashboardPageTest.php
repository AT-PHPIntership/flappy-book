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
use Faker\Factory as Faker;

class DashboardPageTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 8;

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
        $this->makeData(self::NUMBER_RECORD_CREATE);
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
                $browser->assertSeeIn("#dashboard-$name .info-box-number", self::NUMBER_RECORD_CREATE);
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
        $this->browse(function (Browser $browser) use ($number, $link, $str) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->click("#dashboard-$link a")
                    ->assertPathIs('/admin/'.$link)
                    ->assertSee('List '.$str);
        });
    }

    /**
    * A Dusk test test sidebar active
    *
    * @dataProvider caseTestConnectPage
    *
    * @return void
    */
    public function testSideBarActive($number, $link) 
    {
        $this->browse(function (Browser $browser) use ($number, $link) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->click("#dashboard-$link a")
                    ->assertSeeIn('.active span', ucfirst($link));
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
        $users = factory(User::class, $row - 1)->create();
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

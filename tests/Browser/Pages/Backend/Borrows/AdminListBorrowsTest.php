<?php

namespace Tests\Browser\Pages\Backend\Borrows;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Category;
use App\Model\Borrow;
use App\Model\Book;
use Faker\Factory as Faker;

class AdminListBorrowsTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 18;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
       parent::setUp();

       $this->createAdminUser();
    }

    /**
     * A Dusk test show view list borrows.
     *
     * @return void
     */
    public function testListBorrows()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin')
                    ->clickLink('Borrows')
                    ->assertPathIs('/admin/borrows')
                    ->assertSee('List Borrower');
        });
    }

    /**
     * A Dusk test list borrows if empty data borrows
     *
     * @return void
     */
    public function testListBorrowsEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/borrows')
                    ->assertSee('List Borrower');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.paginate'));
        });
    }

    /**
    * A Dusk test show record with table borrows has data.
    *
    * @return void
    */
    public function testShowRecord()
    {
        $this->makeData(4);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/borrows');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(4, $elements);
        });
    }

    /**
     * A Dusk test view Admin List Borrower with pagination
     *
     * @return void
     */
    public function testListBooksPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/borrows');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(config('define.borrows.limit_rows'), $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) - 2;
            $this->assertTrue($number_page == ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.borrows.limit_rows'))));
        });
    }

    /**
     * A Dusk test view Admin List Borrower with lastest pagination
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/borrows?page='.ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.borrows.limit_rows'))));
            $elements = $browser->elements('#list-books tbody tr');
            $browser->assertPathIs('/admin/borrows')
                    ->assertQueryStringHas('page', ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.borrows.limit_rows'))));
        });
    }

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

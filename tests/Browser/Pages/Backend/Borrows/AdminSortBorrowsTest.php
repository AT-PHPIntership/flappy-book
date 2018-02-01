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
use DB;

class AdminSortBorrowsTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 5;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
       parent::setUp();

    }

    /*
     * A Dusk test for click link sort
     *
     * @return void
     */
    public function testClickLinksSort()
    {
        $linkSortNames = ['employ_code', 'name', 'email', 'title', 'from_date', 'to_date', 'send_mail_date'];

        $this->browse(function (Browser $browser) use ($linkSortNames) {

            $browser->loginAs($this->user)
                    ->visit('/admin/borrows');

            foreach ($linkSortNames as $name) {
                $browser->click("#link-sort-$name a")
                    ->assertQueryStringHas('sort', $name)
                    ->assertQueryStringHas('order', 'asc')
                    ->click("#link-sort-$name a")
                    ->assertQueryStringHas('sort', $name)
                    ->assertQueryStringHas('order', 'desc');
            }
        });
    }

    /**
     * Make cases for test show data sort list borrows.
     *
     * @return array
     */
    public function dataForTest()
    {
        return [
            ['employ_code', 'users.employ_code', 1],
            ['name', 'users.name', 2],
            ['email', 'users.email', 3],
            ['title', 'books.title', 4],
            ['from_date', 'borrows.from_date', 5],
            ['to_date', 'borrows.to_date', 6],
            ['send_mail_date', 'borrows.send_mail_date', 7],
        ];
    }

    /**
     * A Dusk test data sort list borrows asc
     *
     * @dataProvider dataForTest
     *
     * @return void
     */
    public function testSortListBorrowsAsc($name, $order, $columIndex)
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $borrows = $this->makeQueryBorrows();

        $this->browse(function (Browser $browser) use ($name, $order, $columIndex, $borrows) {
            $browser->loginAs($this->user)
                    ->visit('admin/borrows')
                    ->resize(1200,1600)
                    ->click("#link-sort-$name a");

            $arrAsc = $borrows->orderBy($order, 'asc')->get();
            for ($i = 1; $i <= self::NUMBER_RECORD_CREATE; $i++) {
                $selector = "#list-borrows tbody tr:nth-child($i) td:nth-child($columIndex)";
                $this->assertEquals($browser->text($selector), $arrAsc[$i-1]->$name);
            }
        });
    }

    /**
     * A Dusk test data sort list borrows desc
     *
     * @dataProvider dataForTest
     *
     * @return void
     */
    public function testSortListBorrowsDesc($name, $order, $columIndex)
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $borrows = $this->makeQueryBorrows();

        $this->browse(function (Browser $browser) use ($name, $order, $columIndex, $borrows) {
            $browser->loginAs($this->user)
                    ->visit('admin/borrows')
                    ->click("#link-sort-$name a")
                    ->click("#link-sort-$name a");

            $arrDesc = $borrows->orderBy($order, 'desc')->get();
                                   
            for ($i = 1; $i <= self::NUMBER_RECORD_CREATE; $i++) {
                $selector = "#list-borrows tbody tr:nth-child($i) td:nth-child($columIndex)";
                $this->assertEquals($browser->text($selector), $arrDesc[$i-1]->$name);
            }

        });
    }

    /**
     * A Dusk test data sort list borrows paginate
     *
     * @dataProvider dataForTest
     *
     * @return void
     */
    public function testSortListBorrowsPaginate($name)
    {
        $this->makeData(16);
        $borrows = $this->makeQueryBorrows();

        $this->browse(function (Browser $browser) use ($name) {
            $browser->loginAs($this->user)
                    ->resize(900, 1600)
                    ->visit('/admin/borrows')
                    ->click("#link-sort-$name a")
                    ->click('.pagination li:nth-child(3) a')
                    ->assertQueryStringHas('sort', $name)
                    ->assertQueryStringHas('order', 'asc')
                    ->click("#link-sort-$name a")
                    ->click('.pagination li:nth-child(3) a')
                    ->assertQueryStringHas('sort', $name)
                    ->assertQueryStringHas('order', 'desc');
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
        $users = factory(User::class, $row)->create();
        $userIds = $users->pluck('id')->toArray();
        $employeeCode = $users->pluck('employ_code')->toArray();
        $categoryId = factory(Category::class, 2)->create()->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            $books[] = factory(Book::class)->create([
                'from_person' => $faker->randomElement($employeeCode),
                'category_id' => $faker->randomElement($categoryId),
            ]);
        }
        $bookIds = array_pluck($books, 'id');
        foreach ($userIds as $userId) {
            factory(Borrow::class)->create([
                'book_id' => $faker->randomElement($bookIds),
                'user_id' => $userId,
                'status' => Borrow::BORROWING
            ]);
        }
    }

    public function makeQueryBorrows()
    {
       $fields = [
            'users.employ_code',
            'users.name',
            'users.email',
            'books.title',
            DB::raw("DATE_FORMAT(borrows.from_date, '%d-%m-%Y') as from_date"),
            DB::raw("DATE_FORMAT(borrows.to_date, '%d-%m-%Y') as to_date"),
            DB::raw("DATE_FORMAT(borrows.send_mail_date, '%d-%m-%Y') as send_mail_date"),
        ];
        $borrows = Borrow::select($fields)
                        ->join('books', 'borrows.book_id', '=', 'books.id')
                        ->join('users','borrows.user_id', '=', 'users.id')
                        ->where('borrows.status', Borrow::BORROWING);
        return $borrows;
    }
}

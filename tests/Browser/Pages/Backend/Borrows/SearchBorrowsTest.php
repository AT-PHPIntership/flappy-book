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

class SearchBorrowsTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    const NUMBER_BORROWS = 5;

    const NUMBER_BOOKS = 10;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
       parent::setUp();

       $this->makeData(self::NUMBER_BORROWS);
    }

    /**
     * A Dusk test search borrows with filter name of book
     *
     * @return void
     */
    public function testSearchFilterNameOfBook() {
        // create hard data for test search
        factory(Book::class)->create([
            'from_person' => $this->user->employ_code,
            'category_id' => 1,
            'title' => 'No name 123456789'
        ]);

        factory(Borrow::class)->create([
            'book_id' => self::NUMBER_BOOKS + 1,
            'user_id' => $this->user->id,
            'status' => Borrow::BORROWING
        ]);

        $this->browse(function (Browser $browser){
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1200,1600)
                ->assertSee('List Borrower')
                ->type('search', '123456789')
                ->select('filter', 'title')
                ->click('#btn-search')
                ->assertQueryStringHas('search', '123456789')
                ->assertQueryStringHas('filter', 'title')
                ->assertSee('No name 123456789');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test search borrows with filter name of book but no result
     *
     * @return void
     */
    public function testSearchFilterNameOfBookNoResult() {
        $this->browse(function (Browser $browser){
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1200,1600)
                ->assertSee('List Borrower')
                ->type('search', '123456789')
                ->select('filter', 'title')
                ->click('#btn-search')
                ->assertQueryStringHas('search', '123456789')
                ->assertQueryStringHas('filter', 'title');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     * A Dusk test search borrows with filter name of user
     *
     * @return void
     */
    public function testSearchFilterNameOfUser() {
        // create hard data for test search
        $user = factory(User::class)->create([
            'name' => 'User name xyz'
        ]);
        factory(Borrow::class)->create([
            'book_id' => 1,
            'user_id' => $user->id,
            'status' => Borrow::BORROWING
        ]);

        $this->browse(function (Browser $browser){
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1200,1600)
                ->assertSee('List Borrower')
                ->type('search', 'xyz')
                ->select('filter', 'name')
                ->click('#btn-search')
                ->assertQueryStringHas('search', 'xyz')
                ->assertQueryStringHas('filter', 'name')
                ->assertSee('User name xyz');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(1, $elements);
        });
    }

    /**
     * A Dusk test search borrows with filter name of user but no result
     *
     * @return void
     */
    public function testSearchFilterNameOfUserNoResult() {
        $this->browse(function (Browser $browser){
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1200,1600)
                ->assertSee('List Borrower')
                ->type('search', 'xyz')
                ->select('filter', 'name')
                ->click('#btn-search')
                ->assertQueryStringHas('search', 'xyz')
                ->assertQueryStringHas('filter', 'name');
            $elements = $browser->elements('#list-borrows tbody tr');
            $this->assertCount(0, $elements);
        });
    }
    
    /**
     * Make data for dusk test
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
        for ($i = 0; $i < self::NUMBER_BOOKS; $i++) {
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

<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Category;
use App\Model\Borrow;
use App\Model\Book;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NumberOfBookListUser extends DuskTestCase
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
     * A Dusk test list users.
     *
     * @return void
     */
    public function testListUsers()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin')
                    ->clickLink('Users')
                    ->assertPathIs('/admin/users')
                    ->assertSee('List Users');
        });
    }

    /**
     * A Dusk test add link book borrowed
     *
     * @return void
     */
    public function testAddLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/users')
                    ->assertVisible('#list-users tbody td:nth-child(6) a ')
                    ->visit($browser->attribute('#list-users tbody td:nth-child(6) a ', 'href'))
                    ->assertSee('List Books')
                    ->assertQueryStringHas('userid', '1')
                    ->assertQueryStringHas('option', 'borrowed');
        });
    }

    /**
     * Display index user has total donated and borrowed books
     *
     * @return void
     */
    public function testNumberOfBookAtListUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/users');
            $fields = [
                'users.id',
                'users.employ_code',
                'users.name',
                'users.email',
                DB::raw('COUNT(DISTINCT(books.id)) AS books_donated_count'),
                DB::raw('COUNT(DISTINCT(borrows.book_id)) AS books_borrowed_count'),
            ];
            $users = User::select($fields)
                           ->leftJoin('books', 'users.employ_code', '=', 'books.from_person')
                           ->leftJoin('borrows', 'users.id', '=', 'borrows.user_id')
                           ->groupBy('users.id')
                           ->first();
            $totalDonator = $browser->text('#list-users tbody tr:first-child td:nth-child(5)');
            $totalBorrow = $browser->text('#list-users tbody tr:first-child td:nth-child(6)');
            $this->assertTrue($users->books_donated_count == $totalDonator);
            $this->assertTrue($users->books_borrowed_count == $totalBorrow);
            $browser->assertSee('List Users');
        });
    }

    /**
     * Display record of book by user
     *
     * @return void
     */
    public function testDetailOfBook()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('admin/books?userid=1&option=borrowed')
                    ->assertSee('List Books');
            $fields = [
                'users.id',
                'users.employ_code',
                'users.name',
                'users.email',
                DB::raw('COUNT(DISTINCT(books.id)) AS books_donated_count'),
                DB::raw('COUNT(DISTINCT(borrows.book_id)) AS books_borrowed_count'),
            ];
            $users = User::select($fields)
                           ->leftJoin('books', 'users.employ_code', '=', 'books.from_person')
                           ->leftJoin('borrows', 'users.id', '=', 'borrows.user_id')
                           ->groupBy('users.id')
                           ->first();
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount($users->books_donated_count, $elements);
            $this->assertCount($users->books_borrowed_count, $elements);
        });
    }

    /**
     * A Data test for users and books
     *
     * @return void
     */
    public function makeData()
    {
        $faker = Faker::create();

        factory(Category::class)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();

        $userEmploy_code= DB::table('users')->pluck('employ_code')->toArray();
        $userId= DB::table('users')->pluck('id')->toArray();

        factory(Book::class)->create([
            'category_id' => $faker->randomElement($categoryId),
            'from_person' => $faker->randomElement($userEmploy_code),
            'title' => $faker->sentence(rand(2,5)),
            'author' => $faker->name,
        ]);
        $bookId = DB::table('books')->pluck('id')->toArray();

        factory(Borrow::class)->create([
            'book_id' => $faker->randomElement($categoryId),
            'user_id' => $faker->randomElement($userId),
        ]);
    }
}

<?php

namespace Tests\Browser\Pages\Backend\Books;

use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use App\Model\Qrcode;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class AdminDeleteBookTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Override function setUp() for make user login
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->makeData(1);
    }

    /**
     * Test Admin click button delete book in List Books
     *
     * @return void
     */
    public function testAdminClickButtonDeleleBook()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->assertSee('List Books')
                    ->click('td button.fa-trash-o')
                    ->assertSee('Confirm deletion!');
        });
    }
    
    /**
     * Test admin click button Close when display Popup Confirmation Delete
     *
     * @return void
     */
    public function testAdminConfirmCloseOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books')
                    ->click('td button.fa-trash-o')
                    ->assertSee('Confirm deletion!')
                    ->press('Close')
                    ->assertDontSee('Confirm deletion!');
        });
    }

    /**
     * Test admin click button Delete when display Popup Confirmation Delete
     *
     * @return void
     */
    public function testAdminConfirmDeleteOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/books');
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(1, $elements);
            $browser->click('td button.fa-trash-o')
                    ->assertSee('Confirm deletion!')
                    ->press('Delete')
                    ->assertDontSee('Confirm deletion!')
                    ->assertSee('Delete Book Success!');
            $browser->pause(1000);
            $elements = $browser->elements('#list-books tbody tr');
            $this->assertCount(0, $elements);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {   
        factory(Category::class, 2)->create();
        factory(User::class, 2)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < $row; $i++) {
            factory(Book::class, 1)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($userId)
            ]);
        }
        $bookId = DB::table('books')->pluck('id')->toArray();
        for ($i = 0; $i < $row; $i++) {
            factory(Qrcode::class)->create([
                'book_id' => $faker->unique()->randomElement($bookId)
            ]);
        }
    }
}

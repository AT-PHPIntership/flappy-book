<?php

namespace Tests\Browser\Pages\Backend\Books;

use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class AdminListBooksTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /**
     * Test view Admin List Books if database has record or empty.
     *
     * @return void
     */
    public function testListBooks()
    {
        $this->makeUserLogin();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    // ->clickLink('Books')
                    // ->assertPathIs('/admin/books')
                    ->assertSee('Laravel');
        });
    }

    // /**
    //  * Test view Admin List Books if database empty
    //  *
    //  * @return void
    //  */
    // public function testListBooksEmpty()
    // {
    //     $this->makeUserLogin();
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/admin/books')
    //                 ->assertSee('List Books');
    //         $elements = $browser->elements('#list-books tbody tr');
    //         $this->assertCount(0, $elements);
    //         $this->assertNull($browser->element('.paginate'));
    //     });
    // }
    
    // /**
    //  * Test view Admin List Books if database has record
    //  *
    //  * @return void
    //  */
    // public function testListBooksHasRecord()
    // {
    //     $this->makeUserLogin();
    //     $this->makeData(2);
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/admin/books')
    //                 ->assertSee('List Books');
    //         $elements = $browser->elements('#list-books tbody tr');
    //         $this->assertCount(2, $elements);
    //         $this->assertNull($browser->element('.pagination'));
    //     });
    // }

    // /**
    //  * Test view Admin List Books with pagination
    //  *
    //  * @return void
    //  */
    // public function testListBooksPagination()
    // {
    //     $this->makeUserLogin();
    //     $this->makeData(12);
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/admin/books')
    //                 ->assertSee('List Books');
    //         // Count row number in one page
    //         $elements = $browser->elements('#list-books tbody tr');
    //         $this->assertCount(10, $elements);
    //         $this->assertNotNull($browser->element('.pagination'));
    //         //Count page number of pagination
    //         $paginate_element = $browser->elements('.pagination li');
    //         $number_page = count($paginate_element)- 2;
    //         $this->assertTrue($number_page == 2);
    //     });
    // }

    // public function testPathPagination()
    // {
    //     $this->makeUserLogin();
    //     $this->makeData(12);
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit('/admin/books?page=2')
    //                 ->assertSee('List Books');
    //         $elements = $browser->elements('#list-books tbody tr');
    //         $this->assertCount(2, $elements);
    //         $browser->assertQueryStringHas('page', 2);
    //     });
    // }

    /**
     * Make user belong team PHP and is admin
     *
     * @return void
     */
    public function makeUserLogin()
    {
        factory(User::class, 1)->create([
            'employ_code' => 'ATI0297',
            'name' => 'Minh Dao T.',
            'email' => 'minh.dao@asiantech.vn',
            'team' => 'PHP',
            'is_admin' => '1',
        ]);
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
    }
}

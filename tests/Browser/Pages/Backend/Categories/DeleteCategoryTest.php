<?php

namespace Tests\Browser\Pages\Backend\Categories;

use App\Model\User;
use App\Model\Book;
use App\Model\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use DB;

class DeleteCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CATEGORY = 3;
    const NUMBER_RECORD_BOOK = 5;    
    const NO_CATEGORY_DELETE = 2;    

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->createAdminUser();
        $this->makeData(self::NUMBER_RECORD_CATEGORY);        
    }

    /**
     * Test Admin can't see button delete on default category
     *
     * @return void
     */
    public function testDontSeeDeleteButtonOnDefaultCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories');
            $btnDelete = $browser->elements('#list-categories tbody tr:nth-child('.Category::CATEGORY_DEFAULT.') button');
            $this->assertCount(0, $btnDelete);
        });
    }

    /**
     * Test Admin click button delete on List Categories
     *
     * @return void
     */
    public function testClickButtonDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories')
                    ->click('td button.btn-delete-item')
                    ->assertSee('Confirm deletion!');
        });
    }

    /**
     * Test Admin click button Close on pop up confirmation delete
     *
     * @return void
     */
    public function testClickButtonCloseOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories')
                    ->click('td button.btn-delete-item')
                    ->assertSee('Confirm deletion!')
                    ->press('Close')
                    ->assertDontSee('Confirm deletion!');
        });
    }

    /**
     * Test Admin click button Delete on pop up confirmation delete
     *
     * @return void
     */
    public function testClickButtonDeleteOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories');

            $totalBooksDefault = $browser->text('#list-categories tbody tr:nth-child('.Category::CATEGORY_DEFAULT.') td:nth-child(3)');
            $totalBooksDelete = $browser->text('#list-categories tbody tr:nth-child('.self::NO_CATEGORY_DELETE.') td:nth-child(3)');
            $totalBooksDefaultNew = $totalBooksDefault + $totalBooksDelete;          

            $browser->click('#list-categories tbody tr:nth-child('.self::NO_CATEGORY_DELETE.') button.btn-delete-item')
                    ->press('Delete')
                    ->assertDontSee('Confirm deletion!')
                    ->assertSee('Successfully deleted ');
            // Count number books of category default
            $totalBooksDefault = $browser->text('#list-categories tbody tr:nth-child('.Category::CATEGORY_DEFAULT.') td:nth-child(3)');            
            $this->assertTrue($totalBooksDefault == $totalBooksDefaultNew);                   
            // Count row number in one page
            $elements = $browser->elements('#list-categories tbody tr');
            $this->assertCount(self::NUMBER_RECORD_CATEGORY - 1, $elements);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {   
        factory(Category::class, $row)->create();
        $categoryId = DB::table('categories')->pluck('id')->toArray();
        $userId = DB::table('users')->pluck('employ_code')->toArray();
        $faker = Faker::create();
        for ($i = 0; $i < self::NUMBER_RECORD_BOOK; $i++) {
            factory(Book::class)->create([
                'category_id' => $faker->randomElement($categoryId),
                'from_person' => $faker->randomElement($userId)
            ]);
        }
    }
}

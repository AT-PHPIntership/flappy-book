<?php

namespace Tests\Browser\Pages\Backend\Categories;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\Book;
use App\Model\User;
use App\Model\Category;
use Faker\Factory as Faker;

class AdminListCategoriesTest extends DuskTestCase
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
     * A Dusk test show view list categories.
     *
     * @return void
     */
    public function testListBorrows()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin')
                    ->clickLink('Categories')
                    ->assertPathIs('/admin/categories')
                    ->assertSee('List Categories');
        });
    }

    /**
     * A Dusk test list categories if empty data borrows
     *
     * @return void
     */
    public function testListBorrowsEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories')
                    ->assertSee('List Categories');
            $elements = $browser->elements('#list-categories tbody tr');
            $this->assertCount(0, $elements);
            $this->assertNull($browser->element('.paginate'));
        });
    }

    /**
    * A Dusk test show record with table categories has data.
    *
    * @return void
    */
    public function testShowRecord()
    {
        $this->makeData(6);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories');
            $elements = $browser->elements('#list-categories tbody tr');
            $this->assertCount(6, $elements);
        });
    }

    /**
     * A Dusk test view Admin List categories with pagination
     *
     * @return void
     */
    public function testListBooksPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories');
            $elements = $browser->elements('#list-categories tbody tr');
            $this->assertCount(config('define.categories.limit_rows'), $elements);
            $this->assertNotNull($browser->element('.pagination'));
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element) - 2;
            $this->assertTrue($number_page == ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.categories.limit_rows'))));
        });
    }

    /**
     * A Dusk test view Admin List categories with lastest pagination
     *
     * @return void
     */
    public function testPathPagination()
    {
        $this->makeData(self::NUMBER_RECORD_CREATE);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visit('/admin/categories?page='.ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.categories.limit_rows'))));
            $elements = $browser->elements('#list-categories tbody tr');
            $browser->assertPathIs('/admin/categories')
                    ->assertQueryStringHas('page', ceil((self::NUMBER_RECORD_CREATE + 1) / (config('define.categories.limit_rows'))));
        });
    }

    /**
     * A Data test for users, categories and books
     *
     * @return void
     */
    public function makeData($row)
    {
        $faker = Faker::create(); 
        $employeeCode = factory(User::class, 2)->create()->pluck('employ_code')->toArray();
        for ($i = 0; $i < $row; $i++) {
            $categories[] = factory(Category::class)->create();
            $categoryId = array_pluck($categories, 'id');
            factory(Book::class)->create([
                'from_person' => $faker->randomElement($employeeCode),
                'category_id' => $faker->randomElement($categoryId),
            ]);
        }
    }
}
 
<?php

namespace Tests\Browser\Pages\Backend\Categories;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Model\User;
use App\Model\Book;
use App\Model\Category;
use Faker\Factory as Faker;
use DB;

class AddCategoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_BOOK = 5;
    const TITLE_CREATED = 'Dr. Buford Mante';
    const TITLE_NOT_EXIST = 'Rodolfo Corwin';

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        factory(Category::class)->create([
            'title' => self::TITLE_CREATED,
        ]);
        $this->makeData();        
    }

    /**
     * Test Admin can see button Add Category
     *
     * @return void
     */
    public function testSeeAddButtonCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->assertSee('Add Category');
        });
    }

    /**
     * Test Admin click button add on List Categories
     *
     * @return void
     */
    public function testClickButtonAdd()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->press('#btn-add-category')
                ->assertSee('Title:');
        });
    }

    /**
     * Test Admin click button Add on Popup when no input data
     *
     * @return void
     */
    public function testClickAddOnPopUpNoInput() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->press('#btn-add-category')
                ->assertSee('Title:')
                ->press('Add')
                ->pause(1000)
                ->assertSee('The title field is required.');
        });
    }

    /**
     * Test Admin click button Close on Popup
     *
     * @return void
     */
    public function testClickCloseOnPopUp() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->press('#btn-add-category')
                ->assertSee('Title:')
                ->press('Close')
                ->assertDontSee('Title:');
        });
    }

    /**
     * Test Admin click button Add on Popup when data input existed
     *
     * @return void
     */
    public function testClickAddDataExist() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->press('#btn-add-category')
                ->assertSee('Title:')
                ->type('title', self::TITLE_CREATED)
                ->press('Add')
                ->pause(2000)
                ->assertSee('The title has already been taken.');
        });
    }

    /**
     * Test Admin click button Add on Popup when data input existed
     *
     * @return void
     */
    public function testClickAddDataNotExist() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->press('#btn-add-category')
                ->assertSee('Title:')
                ->type('title', self::TITLE_NOT_EXIST)
                ->press('Add')
                ->pause(2000)
                ->assertSee('Successfully add the "'.self::TITLE_NOT_EXIST.'" category!');
        });
    }
    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {   
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

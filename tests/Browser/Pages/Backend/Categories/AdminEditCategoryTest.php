<?php

namespace Tests\Browser\Pages\Backend\Cattegories;

use App\Model\User;
use App\Model\Category;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use DB;

class AdminEditCategoryTest extends DuskTestCase
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
        factory(Category::class)->create([
            'title' => 'Default Category'
        ]);
    }

    /**
     * Test view Admin Edit button
     *
     * @return void
     */
    public function testButtonEditCategory()
    {
        $this->makeData(5);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1200,1600)
                    ->assertSee('List Categories');
            $elements = $browser->elements('.btn-edit-category');
            $this->assertCount(5, $elements);
        });
    }

    /**
     * Test click Edit button
     *
     * @return void
     */
    public function testClickButtonEditCategory()
    {
        $category = $this->makeData(1)->first();
        $this->browse(function (Browser $browser) use ($category) {
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1200,1600)
                    ->assertSee('List Categories');
            $browser->press('.btn-edit-category')
                    ->assertInputValue('.item-2 input', $category->title);
        });
    }

    /**
     * Test show popup confirm edit
     *
     * @return void
     */
    public function testShowConfirmEditCategory()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1200,1600)
                    ->press('.btn-edit-category')
                    ->keys('.item-2 input', '{enter}')
                    ->assertSee('Confirm edit!')
                    ->assertSee('Do you want edit from');
        });
    }

    /**
     * Test button cancel button in popup confirm edit
     *
     * @return void
     */
    public function testCancelButtonConfirm()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $input = '.item-2 input';
            $text = '.item-2 p';
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1200,1600)
                    ->press('.btn-edit-category')
                    ->keys($input, '{enter}', ' edited');
            $value = $browser->value($input);
            $browser->press('Cancel')
                    ->assertInputValue($input, $value);
        });
    }

    /*
     * Test button reset button in popup confirm edit
     *
     * @return void
     */
    public function testResetButtonConfirm()
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) {
            $input = '.item-2 input';
            $text = '.item-2 p';
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1200,1600);
            $value = $browser->value($text);
            $browser->press('.btn-edit-category')
                    ->keys($input, '{enter}', 'otwell')
                    ->press('Reset')
                    ->assertSelected($text, $value);
        });
    }

    /**
     * List case for Test validate for input edit category
     *
     */
    public function listCaseTestValidateForInput()
    {
        return [
            ['', 'The title field is required.'],
            ['Default Category', 'The title has already been taken.'],
        ];
    }

    /**
     * Test validate for title
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateEditCategory($content, $message)
    {
        $this->makeData(1);
        $this->browse(function (Browser $browser) use ($content, $message) {
            $input = '.item-2 input';
            $text = '.item-2 p';
            $browser->loginAs($this->user)
                    ->visit('/admin/categories')
                    ->resize(1200,1600)
                    ->press('.btn-edit-category')
                    ->type($input, $content)
                    ->keys($input, '{enter}')
                    ->pause(1000)
                    ->press('Edit')
                    ->pause(1000)
                    ->assertSee($message);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {
       return factory(Category::class, $row)->create();
    }
}

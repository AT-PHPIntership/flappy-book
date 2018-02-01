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

    const DEFAULT_CATEGORY = 'Default Category';
    const NUMBER_RECORD_CREATE = 5;
    const PRESS_ENTER = '{enter}';

    protected $buttonSelected = '.item-2 .btn-edit-category';
    protected $inputSelected = '.item-2 input';
    protected $textSelected = '.item-2 p';

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        factory(Category::class)->create([
            'title' => self::DEFAULT_CATEGORY
        ]);
        $this->makeData(self::NUMBER_RECORD_CREATE);
    }

    /**
     * Test view Admin Edit button
     *
     * @return void
     */
    public function testButtonEditCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1200,1600)
                ->assertSee('List Categories');
            $elements = $browser->elements('.btn-edit-category');
            $this->assertCount(self::NUMBER_RECORD_CREATE + 1, $elements);
        });
    }

    /**
     * Test click Edit button
     *
     * @return void
     */
    public function testClickButtonEditCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1200,1600);
            $text = $browser->text($this->textSelected);
            $browser->press($this->buttonSelected)
                ->assertInputValue($this->inputSelected, $text);
        });
    }

    /**
     * Test show popup confirm edit
     *
     * @return void
     */
    public function testShowConfirmEditCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1200,1600);
            $text = $browser->text($this->textSelected);
            $browser->press($this->buttonSelected)
                ->keys($this->inputSelected, ' edited', self::PRESS_ENTER);
            $input = $browser->value($this->inputSelected); 
            $browser->assertSee('Confirm edit!')
                ->assertSee('Are you sure to edit this category from ' . $text . ' to ' . $input . ' ?');
        });
    }

    /**
     * Test button cancel button in popup confirm edit
     *
     * @return void
     */
    public function testCancelButtonConfirm()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1200,1600)
                ->press($this->buttonSelected)
                ->keys($this->inputSelected, ' edited', self::PRESS_ENTER);
            $value = $browser->value($this->inputSelected);
            $browser->press('Cancel')
                ->assertInputValue($this->inputSelected, $value);
        });
    }

    /**
     * Test button reset button in popup confirm edit
     *
     * @return void
     */
    public function testResetButtonConfirm()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1200,1600);
            $value = $browser->value($this->textSelected);
            $browser->press($this->buttonSelected)
                ->keys($this->inputSelected, ' edited', self::PRESS_ENTER)
                ->press('Reset')
                ->assertSelected($this->textSelected, $value);
        });
    }

    /**
     * List case for Test validate for input edit category
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
        $this->browse(function (Browser $browser) use ($content, $message) {
            $browser->loginAs($this->user)
                ->visit('/admin/categories')
                ->resize(1200,1600)
                ->press($this->buttonSelected)
                ->type($this->inputSelected, $content)
                ->keys($this->inputSelected, self::PRESS_ENTER)
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

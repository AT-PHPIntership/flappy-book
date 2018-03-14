<?php

namespace Tests\Browser\Pages\Backend\Language;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Model\Language;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditLanguageTest extends DuskTestCase
{
    use DatabaseMigrations;

    const DEFAULT_LANGUAGE = 'Default Language';
    const NUMBER_RECORD_LANGUAGE = 3;
    const PRESS_ENTER = '{enter}';

    protected $buttonSelected = '.item-2 .btn-edit-language';
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
        
        $this->makeData();
    }

    /**
     * Test view Admin Edit button
     *
     * @return void
     */
    public function testButtonEditLanguage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->resize(1200,1600)
                ->assertSee('List Languages');
            $elements = $browser->elements('.btn-edit-language');
            $this->assertCount(self::NUMBER_RECORD_LANGUAGE + 1, $elements);
        });
    }

    /**
     * Test click Edit button
     *
     * @return void
     */
    public function testClickButtonEditLanguage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
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
    public function testShowConfirmEditLanguage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
                ->resize(1200,1600);
            $text = $browser->text($this->textSelected);
            $browser->press($this->buttonSelected)
                ->keys($this->inputSelected, ' edited', self::PRESS_ENTER);
            $input = $browser->value($this->inputSelected); 
            $browser->assertSee('Confirm edit!')
                ->assertSee('Are you sure to edit this language from ' . $text . ' to ' . $input . ' ?');
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
                ->visit('/admin/languages')
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
                ->visit('/admin/languages')
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
            ['', 'The language field is required.'],
            ['Default Language', 'The language has already been taken.'],
        ];
    }

    /**
     * Test validate for title
     *
     * @dataProvider listCaseTestValidateForInput
     *
     * @return void
     */
    public function testValidateEditLanguage($content, $message)
    {
        $this->browse(function (Browser $browser) use ($content, $message) {
            $browser->loginAs($this->user)
                ->visit('/admin/languages')
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
    public function makeData()
    {
        factory(Language::class)->create([
            'language' => self::DEFAULT_LANGUAGE
        ]);
        
        foreach (Language::LANGUAGES as $language) {
            factory(Language::class)->create([
                'language' => $language,
            ]);
        }
    }
}

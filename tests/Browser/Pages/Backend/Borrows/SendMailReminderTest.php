<?php

namespace Tests\Browser\Pages\Backend\Borrows;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\Borrow;
use App\Model\Book;
use App\Model\Category;

class SendMailReminderTest extends DuskTestCase
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

        $this->makeData();
    }

    /**
     * Test Admin click button reminder in List Borrowers
     *
     * @return void
     */
    public function testAdminClickReminderButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1920, 1080)
                ->assertSee('List Borrower')
                ->click('td button.fa-bell-o')
                ->assertSee('Confirm reminder send mail!')
                ->assertSee('Are you sure to send mail reminder for this user, ' . $this->user->name . ' ?');
        });
    }

    /**
     * Test admin click button Close when display Popup Confirmation Reminder
     *
     * @return void
     */
    public function testAdminConfirmCloseOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1920, 1080)
                ->click('td button.fa-bell-o')
                ->assertSee('Confirm reminder send mail!')
                ->press('Close')
                ->assertDontSee('Confirm reminder send mail!');
        });
    }

    /**
     * Test admin click button Send when display Popup Confirmation Remider
     *
     * @return void
     */
    public function testAdminConfirmSendOnPopup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/borrows')
                ->resize(1920, 1080)
                ->click('td button.fa-bell-o')
                ->assertSee('Confirm reminder send mail!')
                ->press('Send')
                ->pause(10000)
                ->assertDontSee('Confirm reminder send mail!')
                ->assertSee('Send mail success!');
        });
    }
    
    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData()
    {   
        $faker = Faker::create();
        $categoryId = factory(Category::class, 2)->create()->pluck('id')->toArray();
        $book = factory(Book::class)->create([
            'from_person' => $this->user->employ_code,
            'category_id' => $faker->randomElement($categoryId),
        ]);
        factory(Borrow::class)->create([
            'book_id' => $book->id,
            'user_id' => $this->user->id,
            'status' => Borrow::BORROWING
        ]);
    }
}

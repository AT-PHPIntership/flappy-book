<?php

namespace Tests\Browser\Pages\Backend\Posts;

use App\Model\User;
use App\Model\Post;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;

class AdminDeletePostTest extends DuskTestCase
{
    use DatabaseMigrations;

    const NUMBER_RECORD_CREATE = 5;

    protected $postSelected;

    /**
     * Override function setUp() for make user login
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->postSelected = $this->makeData(self::NUMBER_RECORD_CREATE)->first();
    }

    /**
     * Test Admin click button delete post in detail Post
     *
     * @return void
     */
    public function testClickButtonDelelePost()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/admin/posts/'.$this->postSelected->id)
                ->resize(1200,1600)
                ->assertSee('Detail Post')
                ->press('Delete')
                ->assertSee('Confirm Deletion!');
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
                ->visit('/admin/posts/'.$this->postSelected->id)
                ->resize(1200,1600)
                ->press('Delete')
                ->assertSee('Confirm Deletion!')
                ->press('Close')
                ->assertDontSee('Confirm Deletion!');
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
                    ->visit('/admin/posts/'.$this->postSelected->id)
                    ->resize(1200,1600)
                    ->press('Delete')
                    ->assertSee('Confirm Deletion!')
                    ->press('Delete')
                    ->pause(1000)
                    ->assertDontSee('Confirm Deletion!')
                    ->assertSee('Delete post success!');
            $elements = $browser->elements('#list-posts tbody tr');
            $this->assertCount(self::NUMBER_RECORD_CREATE - 1, $elements);
        });
    }

    /**
     * Make data for test.
     *
     * @return void
     */
    public function makeData($row)
    {
        return factory(Post::class, $row)->create([
            'user_id' => $this->user->id
        ]);
    }
}

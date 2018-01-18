<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;

class AdminListUserTest extends DuskTestCase
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

        $this->makeAdminLogin();
        factory(User::class, 25)->create();
    }

    /**
    * A Dusk test list users.
    *
    * @return void
    */
    public function testListUsers()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin')
                    ->clickLink('Users')
                    ->assertPathIs('/admin/users')
                    ->assertSee('List Users');
        });
    }

    /**
    * A Dusk test show record with table has data.
    *
    * @return void
    */
    public function testShowRecord()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
            ->visit('/admin/users')
            ->assertSee('List Users');
            $elements = $browser->elements('#list-users tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->element('.pagination'));

        });
    }

    /**
    * Test view Admin List Users with pagination
    *
    * @return void
    */
    public function testListUsersPagination()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users')
                    ->assertSee('List Users');
            // Count row number in one page
            $elements = $browser->elements('#list-users tbody tr');
            $this->assertCount(10, $elements);
            $this->assertNotNull($browser->element('.pagination'));
            //Count page number of pagination
            $paginate_element = $browser->elements('.pagination li');
            $number_page = count($paginate_element)- 2;
            $this->assertTrue($number_page == 3);
        });
    }

    /**
    * Test click page 2 in pagination link
    *
    * @return void
    */
    public function testPathPagination()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users?page=3')
                    ->assertSee('List Users');
            $elements = $browser->elements('#list-users tbody tr');
            $this->assertCount(6, $elements);
            $browser->assertPathIs('/admin/users');
            $browser->assertQueryStringHas('page', 3);
        });
    }
}

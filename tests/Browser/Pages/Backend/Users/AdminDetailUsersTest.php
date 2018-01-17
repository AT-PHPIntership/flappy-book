<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;

class AdminDetailUsersTest extends DuskTestCase
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
         $this->makeUserLogin();
     }

    /**
     * A Dusk test ShowRecord
     *
     * @return void
     */
    public function testShowRecord()
    {
        factory(User::class, 10)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users')
                    ->resize(1000,1200)
                    ->assertPathIs('/admin/users')
                    ->assertSee('List Users');

        });
    }

    /**
     * A Dusk test DetailUser
     *
     * @return void
     */
    public function testDetailUser(){
        factory(User::class, 10)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users')
                    ->resize(1000,1200)
                    ->assertPathIs('/admin/users')
                    ->assertSee('List Users')
                    ->click('.name-id')
                    ->visit('/admin/users/1')
                    ->assertSee('Detail User')
                    ->assertSee('Hieu Le T.')
                    ->assertSee('Back');
        });
    }

    /**
     * A Dusk testBackListlUser
     *
     * @return void
     */
     public function testBackListlUser(){
        factory(User::class, 10)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/admin/users/1')
                    ->resize(1000,1200)
                    ->assertPathIs('/admin/users/1')
                    ->assertSee('Detail User')
                    ->clickLink('Back')
                    ->visit('/admin/users')
                    ->assertSee('List Users');
        });
    }

    /**
     * Make user belong team SA and is admin
     *
     * @return void
     */
    public function makeUserLogin()
    {
        factory(User::class, 1)->create([
            'employ_code' => 'ATI0290',
            'name' => 'Hieu Le T.',
            'email' => 'hieu.le@asiantech.vn',
            'team' => 'SA',
            'is_admin' => '1',
        ]);
    }
}

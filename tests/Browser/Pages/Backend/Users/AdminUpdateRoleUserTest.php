<?php

namespace Tests\Browser\Pages\Backend\Users;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
use App\Model\User;

class AdminUpdateRoleUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * user log in
     * @var App\Model\User
     */
    protected $user;

    /**
     * Override function setUp()
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->user = $this->createAdminUser();
    }

    /**
     * A Dusk test show button team SA.
     *
     * @return void
     */
    public function testShowButtonTeamSA()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1600, 1200)
                    ->loginAs($this->user)
                    ->visit('/admin/users')
                    ->assertSee('Role');
        });
    }

    /**
     * A Dusk test dont show button not team SA
     *
     * @return void
     */
    public function testDontShowButtonNotTeamSA()
    {
        $user = factory(User::class)->create([
            'team'     => User::TEAM_PHP,
            'is_admin' => User::ROLE_ADMIN,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->resize(1600, 1200)
                    ->loginAs($user)
                    ->visit('/admin/users')
                    ->assertDontSee('Role');
        });
    }

    /**
     * A Dusk test show disable button team SA
     *
     * @return void
     */
    public function testDisableButtonTeamSA()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1600, 1200)
                    ->loginAs($this->user)
                    ->visit('/admin/users')
                    ->assertVisible('#role-user-1', 'disable');
        });
    }

    /**
     * A Dusk test press button role admin.
     *
     * @return void
     */
    public function testPressButtonRoleAdmin()
    {
        $user = factory(User::class)->create([
            'team'     => User::TEAM_PHP,
            'is_admin' => User::ROLE_ADMIN,
        ]);

        $userId = $user->id;

        $this->browse(function (Browser $browser) use ($userId) {
            $browser->resize(1600, 1200)
                    ->loginAs($this->user)
                    ->visit('/admin/users')
                    ->assertSee('Role')
                    ->assertVisible('#role-user-'.$userId, 'Admin')
                    ->press('#role-user-'.$userId)
                    ->assertVisible('#role-user-'.$userId, 'User');
        });
    }

    /**
     * A Dusk test press button role user.
     *
     * @return void
     */
    public function testPressButtonRoleUser()
    {
        $user = factory(User::class)->create([
            'team'     => User::TEAM_PHP,
            'is_admin' => User::ROLE_USER,
        ]);

        $userId = $user->id;

        $this->browse(function (Browser $browser) use ($userId) {
            $browser->resize(1600, 1200)
                    ->loginAs($this->user)
                    ->visit('/admin/users')
                    ->assertSee('Role')
                    ->assertVisible('#role-user-'.$userId, 'User')
                    ->press('#role-user-'.$userId)
                    ->assertVisible('#role-user-'.$userId, 'Admin');
        });
    }
}

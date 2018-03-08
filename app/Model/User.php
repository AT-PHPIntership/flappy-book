<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'users';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['expired_at', 'deleted_at'];

    /**
     * Constant admin team
     * Set role admin 1
     * Set role user 0
     *
     * @var constants
     */
    const ADMIN_TEAM_NAME = 'SA';
    const ROLE_ADMIN = 1;
    const ROLE_USER = 0;
    const TEAM_PHP = 'PHP';
    const TEAM_IOS = 'IOS';
    const TEAM_ANDROID = 'ANDROID';
    const TEAM_BO = 'BO';
    const TEAM_SA = 'SA';
    const DEFAULT_EMAIL = 'example@asiantech.vn';
    const DEFAULT_NAME = 'null';
    const DEFAULT_TEAM = 'null';
    const DEFAULT_AVATAR_URL = 'null';
    const DEFAULT_EMPLOYEE_CODE = 'AT0001';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'employ_code',
       'name',
       'email',
       'team',
       'expires_at',
       'avatar_url',
       'is_admin',
       'access_token',
    ];
   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship hasMany with Borrow
     *
     * @return array
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Relationship hasMany with Book
     *
     * @return array
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'from_person', 'employ_code');
    }

    /**
     * Relationship hasMany with Post
     *
     * @return array
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relationship hasMany with Comment
     *
     * @return array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Save qr for imported list
     *
     * @param string $employcode employcode user
     *
     * @return void
     */
    public static function saveImportUser($employcode)
    {
        $user['employ_code'] = $employcode;
        $user['email'] = User::DEFAULT_EMAIL;
        $user['name'] = User::DEFAULT_NAME;
        $user['team'] = User::DEFAULT_TEAM;
        $user['avatar_url'] = User::DEFAULT_AVATAR_URL;
        self::lockForUpdate()->firstOrCreate($user);
    }
}

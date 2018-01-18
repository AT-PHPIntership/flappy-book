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
}

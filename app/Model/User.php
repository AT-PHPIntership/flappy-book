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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employ_code',
        'name',
        'email',
        'team',
        'avatar_url',
        'is_admin'
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
        return $this->hasMany(Book::class);
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

<?php

namespace App;

use App\Model\Borrow;
use App\Model\Book;
use App\Model\Post;
use App\Model\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
    * Declare table
    *
    * @var string $tabel table name
    */
    protected $table = 'users';

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

<?php

namespace App\Model;

use App\Model\Post;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'likes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
    ];
    
    /**
     * Relationship belongsTo with User
     *
     * @return array
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship belongsTo with Post
     *
     * @return array
     */
    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}

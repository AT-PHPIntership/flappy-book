<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * Commentable type
     */
    const COMMENTABLE_TYPE = 'post';

    /**
     * Value of status post
     */
    const TYPE_STATUS = 0;

    /**
     * Value of find book post
     */
    const TYPE_FIND_BOOK = 1;

    /**
     * Value of review book post
     */
    const TYPE_REVIEW_BOOK = 2;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'posts';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
        'is_findbook',
    ];

    public $filterable = [
        'id',
        'user_id',
        'content',
        'status',
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
     * Relationship hasMany with Like
     *
     * @return array
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relationship morphMany with Comment
     *
     * @return array
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Override parent boot and Call deleting likes and comments
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Post $post) {
            $post->likes()->delete();
            $post->comments()->delete();
        });
    }

    /**
     * Relationship hasOne with Rating
     *
     * @return array
     */
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}

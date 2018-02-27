<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Traits\FilterTrait;

class Post extends Model
{
    use SoftDeletes, FilterTrait;

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
    const STATUS_COLUMN = 'status';

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

    /**
     * The attributes that can be filter.
     *
     * @var array $filterableFields
     */
    protected $filterableFields = [
        'columns' => [
            self::STATUS_COLUMN,
        ],
        'joins' => [
            'users' => ['posts.user_id', 'users.id'],
            'ratings' => ['posts.id', 'ratings.post_id'],
            'books' => ['books.id', 'ratings.book_id'],
            'likes' => ['posts.id', 'likes.post_id'],
        ],
    ];
}

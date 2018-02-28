<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

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
     * Get list of the resource.
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getPosts()
    {
        $fields = [
            'posts.id',
            'posts.user_id',
            'posts.content',
            'posts.status',
            'users.name',
            'users.team',
            'users.avatar_url',
            'users.is_admin',
            'books.picture',
            'books.title',
            'ratings.book_id',
            'ratings.rating',
            DB::raw('COUNT(likes.id) AS likes'),
            DB::raw('DATE_FORMAT(posts.created_at,"'.config('define.posts.date_time_format').'") AS create_date'),
            DB::raw('DATE_FORMAT(posts.updated_at,"'.config('define.posts.date_time_format').'") AS update_date'),
        ];

        $posts = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftjoin('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->groupBy('posts.id');

        return $posts;
    }
}

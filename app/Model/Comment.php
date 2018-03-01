<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * Book type
     */
    const BOOK_TYPE = 'book';

    /**
     * Post type
     */
    const POST_TYPE = 'post';

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'comments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'comment',
        'parent_id'
    ];

    /**
     *  Relationship belongsTo with User
     *
     * @return array
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *  Relationship hasMany with Comment
     *
     * @return array
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     *  Relationship belongsTo with Comment
     *
     * @return array
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Relationship morphTo with Book and Post
     *
     * @return array
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get commments
     *
     * @return array
     */
    public static function getComments()
    {
        $fields = [
            'comments.id',
            'comments.comment',
            'comments.commentable_id',
            'comments.commentable_type',
            'users.name',
            'users.team',
            'users.avatar_url',
            'users.is_admin',
            'comments.parent_id',
            'comments.created_at',
            'comments.updated_at',
            'comments.deleted_at',
        ];

        $comments = Comment::select($fields)->join('users', 'comments.user_id', 'users.id');

        return $comments;
    }
}

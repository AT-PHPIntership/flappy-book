<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
     use SoftDeletes;
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
        return $this->hasMany(Comment::class);
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
      * Deleting comment hw_Children(connection, objectID)
      *
      * @return void
    */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Comment $comment) {
            $comment->comment()->delete();
        });
    }
}

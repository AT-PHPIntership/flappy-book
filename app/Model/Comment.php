<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

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
        'comment_id',
        'comment_table',
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
     * Relationship morphTo with Book and Post
     *
     * @return array
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}

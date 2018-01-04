<?php

namespace App\Model;

use App\Model\Comment;
use App\Model\User;
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
     * The Comment belong to the with User
     *
     * @return array
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get all of the owning commentable models.
     *
     * @return array
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}

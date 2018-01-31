<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'rating',
    ];

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

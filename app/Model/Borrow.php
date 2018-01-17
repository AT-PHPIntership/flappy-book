<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    /**
     * Borrows currency status
     *
     * @type int
     */
    const BORROWING = 0;

    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'borrows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id',
        'user_id',
        'status',
        'from_date',
        'to_date'
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
     * Relationship belongsTo with Book
     *
     * @return array
     */
    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}

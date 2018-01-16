<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    /**
     * Declare table
     *
     * @var string $table table name
     */
    protected $table = 'qrcodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'book_id',
        'prefix',
        'code_id',
        'status'
    ];

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

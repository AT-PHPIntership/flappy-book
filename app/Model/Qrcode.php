<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    /**
     * Default code_id of qrcode
     */
    const DEFAULT_CODE_ID = 1;

    /**
     * Default qrcode prefix
     */
    const DEFAULT_CODE_PREFIX = 'ATB';

    /**
     * Default not print status on qrcode table
     */
    const NOT_PRINT_STATUS = 0;

    /**
     * Default number of number code_id
     */
    const NUMBER_OF_NUMBERS = 4;

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
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}

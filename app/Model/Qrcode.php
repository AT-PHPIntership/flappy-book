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

    const IS_NOT_PRINTED = 0;

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
     * Declare qrcode book
     *
     * @return $qrcode
     */
    public function getQrcodeBookAttribute()
    {
        $qrcode = $this->prefix . sprintf(config('define.qrcodes.number_format'), $this->code_id);
        return $qrcode;
    }

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

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qrcode extends Model
{
    use SoftDeletes;

    /**
     * Default code_id of qrcode
     */
    const DEFAULT_CODE_ID = 1;

    /**
     * Default qrcode prefix
     */
    const DEFAULT_CODE_PREFIX = 'ATB-';

    const IS_NOT_PRINTED = 0;

    const IS_PRINTED = 1;

    const LENGTH_OF_QRCODE = 4;

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

    /**
     * Save qr for imported list
     *
     * @param string         $prefix   prefix qrcode
     * @param string         $codeId   code id qrcode
     * @param App\Model\Book $bookdata $bookdata
     *
     * @return void
     */
    public static function saveImportQRCode($prefix, $codeId, $bookdata)
    {
        $qrcodes = [
            'book_id' => $bookdata->id,
            'prefix' => $prefix,
            'code_id' => $codeId,
        ];
        self::lockForUpdate()->firstOrCreate($qrcodes);
    }
}

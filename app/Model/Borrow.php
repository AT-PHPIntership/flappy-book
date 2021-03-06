<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Libraries\Traits\SearchTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrow extends Model
{
    use Sortable, SearchTrait, SoftDeletes;

    /**
     * Borrows currency status
     *
     * @type int
     */
    const BORROWING = 0;
    const TYPE_NAME = 'name';
    const TYPE_TITLE = 'title';

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
        'to_date',
        'send_mail_date'
    ];

    /**
    * Declare table sort
    *
    * @var array $sortable table sort
    */
    public $sortable = [
        'from_date',
        'to_date',
        'send_mail_date'
    ];

    /**
     * Declare table sort
     *
     * @var string $sortableAs
     */
    protected $sortableAs = ['employ_code', 'name', 'email', 'title'];

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

    /**
     * The attributes that can be search.
     *
     * @var array $searchableFields
     */
    protected $searchableFields = [
        'columns' => [
            self::TYPE_NAME,
            self::TYPE_TITLE,
        ],
        'joins' => [
            'books' => ['books.id', 'borrows.book_id'],
            'users' => ['users.id','borrows.user_id'],
        ]
    ];
}

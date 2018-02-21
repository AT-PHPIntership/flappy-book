<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Traits\SearchTrait;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
    use SoftDeletes, SearchTrait, Sortable;
    
    /**
     * Book currency unit
     *
     * @type int
     */
    const TYPE_VND = 0;
    const TYPE_DOLAR = 1;
    const TYPE_EURO = 2;
    const TYPE_YEN = 3;
    const TYPE_ALL = 'all';
    const TYPE_TITLE = 'title';
    const TYPE_AUTHOR = 'author';
    const TYPE_BORROWED = 'borrowed';
    const TYPE_DONATED = 'donated';
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'books';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'year',
        'author',
        'price',
        'unit',
        'picture',
        'from_person',
        'total_rating',
        'rating',
    ];

    /**
    * Declare table sort
    *
    * @var array $sortable table sort
    */
    public $sortable = [
        'title',
        'author',
        'rating',
    ];

    /**
     * Declare table sort
     *
     * @var string $sortableAs
     */
    protected $sortableAs = [
        'total_borrowed',
    ];

    /**
     * Declare casts
     *
     * @var array
     */
    protected $casts = [
        'rating'=> 'real',
        'price' => 'real',
    ];

    /**
     * Relationship belongsTo with Category
     *
     * @return array
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relationship belongsTo with User
     *
     * @return array
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'from_person', 'employ_code');
    }

    /**
     * Relationship hasMany with Borrow
     *
     * @return array
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Relationship morphMany with Comment
     *
     * @return array
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Relationship hasOne with Qrcode
     *
     * @return array
     */
    public function qrcode()
    {
        return $this->hasOne(Qrcode::class);
    }

    /**
     * Relationship hasMany with Post
     *
     * @return array
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Override parent boot and Call deleting borrows and comments
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($books) {
            $books->borrows()->delete();
            $books->comments()->delete();
        });
    }

     /**
     * The attributes that can be search.
     *
     * @var array $searchableFields
     */
    protected $searchableFields = [
        'columns' => [
            self::TYPE_TITLE,
            self::TYPE_AUTHOR,
        ],
        'joins' => [
            'borrows' => ['books.id', 'borrows.book_id']
        ]
    ];
}

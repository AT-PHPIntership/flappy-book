<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Category default
     *
     * @type int
     */
    const CATEGORY_DEFAULT = 1;
    
    /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
    
    /**
     * Relationship hasMany with Book
     *
     * @return array
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Override function boot and change books of category deleted to category default
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($categories) {
            $categories->books()->update(['category_id' => Category::CATEGORY_DEFAULT]);
        });
    }
}

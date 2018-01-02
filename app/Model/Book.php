<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
    * Return value of parameter
    *
    * @var array $fillable get value from input tag
    */
    protected $fillable = [
        'qrcode',
        'category_id',
        'title',
        'description',
        'year',
        'author',
        'picture',
        'from_person',
        'total_rating',
        'rating',
        'is_printed'
    ];

    /**
     * Get the book's category
     *
     * @return array
    */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

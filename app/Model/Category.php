<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
    * Return value of parameter
    *
    * @var array $fillable get value from input tag
    */
    protected $fillable = [
        'title'
    ];

    /**
     * Get the category's books
     *
     * @return array
    */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

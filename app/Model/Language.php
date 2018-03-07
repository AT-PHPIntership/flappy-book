<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const LANGUAGES = [
        'Vietnamese',
        'English',
        'Japanese',
    ];

     /**
     * Declare table
     *
     * @var string $tabel table name
     */
    protected $table = 'languages';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language',
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
}

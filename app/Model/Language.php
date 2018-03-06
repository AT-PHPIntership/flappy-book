<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * Language default
     *
     * @type int
     */
    const LANGUAGE_DEFAULT = 1;
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
        'languages',
    ];
    
    /**
     * Override function boot and change books of category deleted to category default
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($languages) {
            $languages->books()->update(['language_id' => Language::LANGUAGE_DEFAULT]);
        });
    }

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

<?php

namespace App\Service;

use DB;
use App\Model\Book;
use Illuminate\Http\Request;

class BookService
{
    /**
     * Get list of the resource.
     *
     * @param Request $request send request
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getBooks(Request $request = null)
    {
        $fields = [
            'books.id',
            'books.title',
            'books.picture',
            'books.total_rating',
            'books.rating',
            'books.category_id',
            'books.status'
        ];

        $params = $request ? $request->all() : null;
        $books = Book::filter($params)
                ->select($fields)
                ->orderBy('books.created_at', 'DESC');

        return $books;
    }
}

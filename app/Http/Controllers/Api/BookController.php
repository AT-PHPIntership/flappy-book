<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Book;
use Illuminate\Http\Response;

class BookController extends ApiController
{
    /**
     * Get list of books
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $fields = [
            'id',
            'title',
            'picture',
            'total_rating',
         ];
         $books = Book::select($fields)
            ->orderBy('created_at', 'DESC')
            ->get();
         return $this->showAll($books);
    }
}

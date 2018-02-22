<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\Controller;
use App\Model\Book;
use App\Model\Borrow;
use DB;

class BookController extends ApiController
{
    /**
     * Get a listing of the category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'books.title',
            DB::raw('COUNT(borrows.book_id) AS total_borrowed'),
        ];
        $topBorrowed = Borrow::select($fields)
                             ->join('books', 'books.id', '=', 'borrows.book_id')
                             ->groupBy('books.id')
                             ->orderBy('total_borrowed', 'desc')
                             ->get();
        return  $this->showAll($topBorrowed);
    }
}

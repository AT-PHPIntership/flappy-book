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
    * Get top borrow books with paginate and meta.
    *
    * @return \Illuminate\Http\Response
    */
    public function topBorrow()
    {
        $fields = [
            'books.title',
            DB::raw('COUNT(borrows.book_id) AS total_borrowed'),
        ];
        $topBorrowed = Borrow::select($fields)
                            ->join('books', 'books.id', '=', 'borrows.book_id')
                            ->groupBy('books.id')
                            ->orderBy('total_borrowed', 'desc')
                            ->paginate(config('define.book.item_limit')); 
        $meta = [
            'meta' => [
                'message' => 'successfully',
                'code' => Response::HTTP_OK,
            ]
        ];
        $books = collect($topBorrowed)->merge($topBorrowed);
        return response()->json($topBorrowed);
    }
}

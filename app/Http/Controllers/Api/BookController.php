<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
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
        $topBorrowed = Book::select(['title'])
                            ->withCount('borrows')
                            ->orderBy('borrows_count', 'desc')
                            ->paginate(config('define.book.item_limit')); 
        $meta = [
            'meta' => [
                'message' => 'successfully',
                'code' => Response::HTTP_OK,
            ]
        ];
        $topBorrowed = collect($meta)->merge($topBorrowed);
        return response()->json($topBorrowed);
    }

    /**
     * API get detail book
     *
     * @param int $id id of book
     *
     * @return void
     */
    public function show($id)
    {
        $fields = [
            'books.id',
            'books.title',
            'books.category_id',
            'books.description',
            'books.language',
            'books.rating',
            'books.total_rating',
            'books.picture',
            'books.author',
            'books.price','books.unit',
            'books.year',
            'books.page_number',
            'borrows.status',
            'users.id AS user_id',
            'users.name AS donator',
        ];

        $book = Book::select($fields)
                    ->with(['category' => function ($query) {
                        $query->select('id', 'title');
                    }])
                    ->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                    ->join('users', 'books.from_person', '=', 'users.employ_code')
                    ->orderBy('borrows.created_at', 'DESC')
                    ->findOrFail($id);

        return $this->responseSuccess($book);
    }

    /**
     * Get top books review
     *
     * @return \Illuminate\Http\Response
     */
    public function topBooksReview()
    {
        $fields =  [
            'id',
            'title',
            'rating',
            'total_rating',
            'picture'
        ];

        $topBooks = Book::select($fields)
                    ->orderBy('total_rating', 'DESC')
                    ->orderBy('rating', 'DESC')
                    ->limit(config('define.books.amount_top_books_review'))
                    ->get();
        
        return $this->responseSuccess($topBooks);
    }
}

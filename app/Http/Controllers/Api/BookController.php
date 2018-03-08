<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\Book;

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
            'rating',
        ];
        $books = Book::select($fields)
            ->orderBy('created_at', 'DESC')
            ->paginate(config('define.books.limit_item'));

        return $this->responsePaginate($books);
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
            'books.language_id',
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
                    ->with(['language' => function ($query) {
                        $query->select('id', 'language');
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

    /**
     * Get top books borrow.
     *
     * @return \Illuminate\Http\Response
     */
    public function topBooksBorrow()
    {
        $fields =  [
            'id',
            'title',
            'rating',
            'total_rating',
            'picture'
        ];

        $topBooks = Book::select($fields)
                    ->withCount('borrows')
                    ->orderBy('borrows_count', 'desc')
                    ->paginate(config('define.books.limit_item'));
                        
        return $this->responsePaginate($topBooks);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\Book;
use DB;

class BookController extends ApiController
{
    public function index(){
        $fields = [
            'books.id',
            'books.title',
            'books.author',
            'books.picture',
            'books.total_rating',
         ];
        $books = Book::search(request('search'), request('filter'))
            ->select($fields)
            ->groupBy('books.id')
            ->orderBy('books.created_at', 'DESC')
            ->paginate(config('define.book.item_limit'));
            $meta = [
                'meta' => [
                    'message' => 'successfully',
                    'code' => Response::HTTP_OK,
                ]
            ];
            $books = collect($meta)->merge($books);
        
            return response()->json($books);
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

        return $this->showOne($book);
    }
}

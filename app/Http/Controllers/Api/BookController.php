<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Book;

class BookController extends Controller
{
    /**
     * API get detail book
     *
     * @param int $id id of book
     *
     * @return void
     */
    public function show($id)
    {
        $fileds = [
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
        $book = Book::select($fileds)
                    ->with(['category' => function($query) {
                        $query->select('id', 'title');
                    }])     
                    ->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                    ->join('users', 'books.from_person', '=', 'users.employ_code')
                    ->orderBy('borrows.created_at', 'DESC')
                    ->find($id);
                    
        if ($book) {
            $book->picture = url('/').'/'.config('define.books.folder_store_books').$book->picture;            
            return response()->json([
                'meta' => [
                    'status' => 'successfuly',
                    'code' => 200,
                ],
                'data' => $book,
            ]);
        }

        return response()->json([
            'meta' => [
                'status' => 'failed',
                'code' => 404,
            ],
            'error' => [
                'message' => 'Page not found!',
            ],
        ], Response::HTTP_NOT_FOUND);
    }
}

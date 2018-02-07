<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Book;

class BookController extends Controller
{
    public function show($id)
    {
        $fileds = [
            'categories.title AS category',
            'books.id as book_id',
            'books.title',
            'books.description',
            'books.language',
            'books.rating',
            'books.picture',
            'books.author',
            'books.price','books.unit',
            'books.year',
            'books.page_number',
		    'borrows.status',
            'users.id AS user_id',
            'users.name AS donater',
        ];
        $book = Book::select($fileds)
                    ->join('categories', 'books.category_id', '=', 'categories.id')
                    ->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                    ->join('users', 'books.from_person', '=', 'users.employ_code')
                    ->orderBy('borrows.id', 'DESC')
                    ->firstOrFail($id);

        if ($book) {
            return response()->json(collect(['success' => true])->merge($book));
        }
        $error = __('Has error during access this page');
        return response()->json(['error' => $error]);
    }
}

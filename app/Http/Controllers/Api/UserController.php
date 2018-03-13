<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\User;
use App\Model\Borrow;
use DB;
use App\Model\Book;

class UserController extends ApiController
{
    /**
     * API get info user
     *
     * @param int $id id of user
     *
     * @return void
     */
    public function show($id)
    {
        $fields = [
            'users.id',
            'users.employ_code',
            'users.name',
            'users.team',
            'users.email',
            'users.is_admin',
            'users.avatar_url',
            'books.title AS book_borrowing'
        ];

        $user = User::select($fields)
                    ->leftJoin('borrows', function ($query) {
                        return $query->on('borrows.user_id', 'users.id')->where('borrows.status', Borrow::BORROWING);
                    })
                    ->leftJoin('books', 'books.id', 'borrows.book_id')
                    ->withCount(['books AS donated', 'borrows AS borrowed'])
                    ->where('users.id', $id)
                    ->firstOrFail();

        return $this->responseSuccess($user);
    }

    /**
     * Api get books of user donated
     *
     * @param integer $id id of user
     *
     * @return \Illuminate\Http\Response
     */
    public function getBooksDonated(int $id)
    {
        $fields = [
            'books.id',
            'books.title',
            'books.description',
            'languages.language',
            'books.rating',
            'books.total_rating',
            'books.picture',
            'books.author',
            'books.price',
            'books.unit',
            'books.year',
            'books.page_number'
        ];

        $books = Book::select($fields)
                    ->join('languages', 'books.language_id', 'languages.id')
                    ->join('users', 'users.employ_code', 'books.from_person')
                    ->where('users.id', $id)
                    ->orderBy('books.created_at', 'DESC')
                    ->paginate(config('define.books.amount_books_donated'));

        return $this->responsePaginate($books);
    }
}

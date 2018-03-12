<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Model\User;
use League\Fractal\Manager;
use App\Transformers\UserTransformer;
use App\Model\Borrow;
use DB;
use App\Model\Book;

class UserController extends ApiController
{
    /**
     * UserController construct
     *
     * @param Manager         $fractal     fractal
     * @param UserTransformer $transformer transformer
     *
     * @return void
     */
    public function __construct(Manager $fractal, UserTransformer $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    /**
     * API get info user
     *
     * @param int $id id of user
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user = $this->transformerResource($user, ['book_borrowing', 'borrowed', 'donated']);
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
            'books.language',
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
                    ->join('users', 'users.employ_code', 'books.from_person')
                    ->where('users.id', $id)
                    ->orderBy('books.created_at', 'DESC')
                    ->paginate(config('define.books.amount_books_donated'));

        return $this->responsePaginate($books);
    }
}

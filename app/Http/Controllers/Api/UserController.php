<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\User;
use App\Model\Borrow;
use DB;

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

        return $this->responseObject($user);
    }
}

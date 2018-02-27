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
            DB::raw("(SELECT books.title FROM books WHERE id IN (SELECT borrows.book_id FROM borrows WHERE users.id = borrows.user_id AND borrows.status = " . Borrow::BORROWING . ")) AS book_borrowing")
        ];

        $user = User::select($fields)
                    ->withCount(['books AS donated', 'borrows AS borrowed'])
                    ->where('id', $id)
                    ->firstOrFail();

        return $this->responseObject($user);
    }
}

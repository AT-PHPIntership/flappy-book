<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use App\Model\User;
use App\Model\Book;
use App\Model\Borrow;

class UserController extends Controller
{
    /**
     * Display a listing of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'users.id',
            'users.employ_code',
            'users.name',
            'users.team',
            'users.email',
            'users.is_admin',
            'users.avatar_url',
        ];
        $users = User::select($fields)
        ->withCount(['books', 'borrows'])
        ->orderBy('id')
        ->paginate(config('define.users.limit_rows'));

        return view('backend.users.index', ['users' => $users]);
    }
     /**
     * Display the profile of user.
     *
     * @param int $id id of user
     *
     * @return \Illuminate\Http\Response
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
            DB::raw("(SELECT books.title FROM books WHERE id IN (SELECT borrows.book_id FROM borrows WHERE users.id = borrows.user_id AND borrows.status = " . Borrow::BORROWING . ")) AS name_book")
        ];

        $user = User::select($fields)
        ->withCount(['books', 'borrows'])
        ->where('id', $id)
        ->firstOrFail();

        return view('backend.users.show', ['user' => $user]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\User;
use App\Model\Book;

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
        ];

        $user = User::select($fields)
        ->withCount(['books', 'borrows'])
        ->where('id', $id)
        ->first();

        $bookName = DB::table('books')
        ->join('borrows', 'books.id', '=', 'borrows.book_id')
        ->join('users', 'users.id', '=', 'borrows.user_id')
        ->where('users.id', $id)
        ->where('borrows.status', 0)
        ->select('books.title')
        ->first();

        return view('backend.users.show', ['user' => $user, 'bookName' => $bookName]);
    }
}

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


    /**
     * Update role user.
     *
     * @param Interger $userId User Id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateRole(int $userId)
    {
        $user = User::find($userId);
        if ($user->team != User::ADMIN_TEAM_NAME && \Auth::user()->team == User::ADMIN_TEAM_NAME) {
            $user->is_admin = $user->is_admin == User::ROLE_USER ? User::ROLE_ADMIN : User::ROLE_USER;
            $user->save();
            return response($user);
        }

    }
}

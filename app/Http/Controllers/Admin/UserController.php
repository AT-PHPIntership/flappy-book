<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\User;

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
            DB::raw('COUNT(DISTINCT(borrows.id)) AS total_borrowed'),
            DB::raw('COUNT(DISTINCT(books.id)) AS total_donated'),
        ];
        $users = User::leftJoin('borrows', 'users.id', '=', 'borrows.user_id')
        ->leftJoin('books', 'users.employ_code', '=', 'books.from_person')
        ->select($fields)
        ->groupBy('users.id')
        ->paginate(config('define.row_count'));
        // echo '<pre>';
        // print_r($users);
        // echo '</pre>';
        return view('backend.users.index',['users' => $users]);
    }
     /**
     * Display the profile of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('backend.users.show');
    }
}

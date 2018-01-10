<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
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
        ];
        $users = User::select($fields)
        ->withCount(['books', 'borrows'])
        ->orderBy('id')
        ->paginate(config('define.users.row_count'));
        
        return view('backend.users.index', ['users' =>$users]);
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

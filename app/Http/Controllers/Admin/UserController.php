<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.users.index');
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

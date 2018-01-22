<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BorrowController extends Controller
{
    /**
     * Display a listing of the borrower.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.borrows.index');
    }
}

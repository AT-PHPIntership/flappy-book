<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Borrow;
use App\Model\User;
use App\Model\Book;
use DB;

class BorrowController extends Controller
{
    /**
     * Display a listing of the borrower.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'users.employ_code',
            'users.name',
            'users.email',
            'books.title',
            'borrows.from_date',
            'borrows.to_date',
            'borrows.id',
        ];
        $borrows = Borrow::select($fields)
        ->join('users', 'users.id', '=', 'borrows.user_id')
        ->join('books', 'books.id', '=', 'borrows.book_id')
        ->where('borrows.status', Borrow::BORROWING)
        ->with('users', 'books')
        ->sortable()
        ->orderby('from_date', 'desc')
        ->paginate(config('define.borrows.limit_rows'));

        return view('backend.borrows.index', ['borrows' => $borrows]);
    }
}

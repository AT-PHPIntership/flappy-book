<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Borrow;

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
        $borrows = Borrow::search(request('search'), request('filter'))
                ->select($fields)
                ->where('borrows.status', Borrow::BORROWING)
                ->sortable()
                ->orderby('from_date', 'desc')
                ->paginate(config('define.borrows.limit_rows'));

        return view('backend.borrows.index', ['borrows' => $borrows]);
    }
}

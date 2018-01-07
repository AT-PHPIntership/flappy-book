<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Model\Book;
use App\Model\Borrow;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field = [
            'books.id',
            'title',
            'author',
            'rating',
            DB::raw('count(borrows.id) total_borrow')
        ];

        $filterFields = [
            'title',
            'author',
            'rating',
            'total_borrow'
        ];

        $orderFields = [
            'asc',
            'desc'
        ];

        // get value of parameter from url
        $filter = Input::get('filter');
        $order = Input::get('order');
        $books = [];

        // check validate of input
        if ((in_array($filter, $filterFields)) && (in_array($order, $orderFields))) {
            $books = Book::select($field)
                                ->join('borrows', 'books.id', '=', 'borrows.book_id')
                                ->groupBy('books.id')
                                ->orderBy($filter, $order)
                                ->paginate(Book::ROW_LIMIT);
        }

        $order = ($order == 'asc') ? 'desc' : 'asc';
        return view('backend.books.index', compact('books', 'order'));
    }

    /**
     * Show create book page.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        return view('backend.books.create');
    }
}

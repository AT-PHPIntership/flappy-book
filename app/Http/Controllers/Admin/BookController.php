<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\backend\CreateBookRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\Paginator;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Category;

class BookController extends Controller
{

    /**
     * Display a listing of the books.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'books.id',
            'books.title',
            'books.author',
            'books.rating',
            DB::raw('COUNT(borrows.id) AS total_borrowed'),
        ];

        $filterFields = [
            'title',
            'author',
            'rating',
            'total_borrowed'
        ];

        $orderFields = [
            'asc',
            'desc'
        ];

        // get value of parameter from url
        $filter = Input::get('filter');
        $order = Input::get('order');

        // get list books
        $books = Book::select($fields)
                     ->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                     ->groupBy('books.id');

        // check validate of input, sort data
        if ((in_array($filter, $filterFields)) && (in_array($order, $orderFields))) {
            $books = $books->orderBy($filter, $order)
                        ->paginate(config('define.row_count'))
                        ->appends(['filter' => $filter, 'order' => $order]);
        } else {
            $books = $books->orderBy('id', 'desc')
                        ->paginate(config('define.row_count'));
        }

        return view('backend.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'title')->get();
        return view('backend.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request send request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBookRequest $request)
    {
        $title = $request->title;
        echo $title;
    }
}

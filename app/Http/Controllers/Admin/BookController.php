<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditBookRequest;
use App\Http\Requests\Backend\CreateBookRequest;
use DB;
use App\Model\Book;
use App\Model\Category;

class BookController extends Controller
{

    /**
     * Display a listing of the books.
     *
     * @param Request $request send request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $filter = $request->filter;
        $fields = [
            'books.id',
            'books.title',
            'books.author',
            'books.rating',
            DB::raw('COUNT(borrows.id) AS total_borrowed'),
        ];
        
        $sortFields = [
            'title',
            'author',
            'rating',
            'total_borrowed'
        ];

        $orderFields = [
            'asc',
            'desc'
        ];

        $sort = in_array($request->sort, $sortFields) ? $request->sort : 'id';
        $order = in_array($request->order, $orderFields) ? $request->order : 'desc';
        $books = Book::search($search, $filter)
            ->select($fields)
            ->groupBy('books.id')
            ->orderby($sort, $order)
            ->paginate(config('define.books.limit_rows'));
        $books->appends(['search' => request('search')]);
        //check option when click number book on users list
        $userId = $request->userid ? $request->userid : '';
        $option = $request->option? $request->option : '';
        switch ($option) {
            case Book::TYPE_BORROWED:
                $books = $books->whereIn('books.id', function ($query) use ($userId) {
                        $query->select('book_id')
                              ->from('borrows')
                              ->join('users', 'users.id', '=', 'borrows.user_id')
                              ->where('users.id', '=', $userId);
                });
                break;
        }
        return view('backend.books.index', compact('books'));
    }

    /**
     * Get data categories.
     *
     * @param int $id call category have id = $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fields = [
            'id',
            'title'
        ];
        $book = Book::findOrFail($id);
        $categories = Category::select($fields)->get();
        return view('backend.books.edit', compact('book', 'categories'));
    }

    /**
     * Update infomation of Book.
     *
     * @param App\Http\Requests\EditBookRequest $request form edit book
     * @param int                               $id      id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditBookRequest $request, $id)
    {
        dd($request);
        dd($id);
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

    /**
     * Delete a book and relationship.
     *
     * @param Book $book object book
     *
     * @return void
     */
    public function destroy(Book $book)
    {
        $bookDelete = $book->delete();
        if ($bookDelete) {
            flash(__('books.delete_book_success'))->success();
        } else {
            flash(__('books.delete_book_fail'))->error();
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditBookRequest;
use App\Http\Requests\Backend\CreateBookRequest;
use DB;
use App\Model\Book;
use App\Model\Category;
use App\Model\Qrcode;
use App\Model\User;
use App\Libraries\ImageUpdate;

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

        // check filter when search
        switch ($filter) {
            case Book::TYPE_TITLE:
                $books = Book::where('title', 'like', '%'.$search.'%');
                break;
            case Book::TYPE_AUTHOR:
                $books = Book::where('author', 'like', '%'.$search.'%');
                break;
            default:
                $books = Book::where(function ($query) use ($search) {
                    return $query->where('title', 'like', '%'.$search.'%')
                               ->orWhere('author', 'like', '%'.$search.'%');
                });
        }
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
        // get list books
        $books = $books->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                       ->select($fields)
                       ->groupBy('books.id')
                       ->orderBy($sort, $order)
                       ->paginate(config('define.books.limit_rows'))
                       ->appends(['userid' => $userId, 'option' => $option, 'sort' => $sort, 'order' => $order]);

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
     * @param App\Model\Book                    $id      pass id object
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);

        //save image path, move image to directory
        if (isset($request->picture)) {
            $oldPath = $book->picture;
            $result  = ImageUpdate::imageUpdate($request->picture, config('image.book.path'), $oldPath);
            $book->picture = $result;
        }

        //save new donator
        $user = User::where('employ_code', $request->iddonator)->first();
        if (isset($user)) {
            $book->from_person = $request->iddonator;
        }

        if ($book->update($request->except(['iddonator', 'picture']))) {
            flash(__('books.books_edit_success'))->success();
            return redirect()->route("books.index");
        } else {
            flash('books.books_edit_failer')->error();
            return redirect()->back()->withInput();
        }
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

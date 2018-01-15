<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditBookRequest;
use App\Http\Requests\Backend\CreateBookRequest;
use Illuminate\Support\Facades\DB;
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
        $books = Book::leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                 ->select($fields)
                 ->groupBy('books.id')
                 ->orderBy('id', 'desc');
        switch ($filter) {
            case Book::TYPE_TITLE:
                $books = $books->Where('title', 'like', '%'.$search.'%');
                break;
            case Book::TYPE_AUTHOR:
                $books = $books->Where('author', 'like', '%'.$search.'%');
                break;
            default:
                $books = $books->Where('title', 'like', '%'.$search.'%')->orWhere('author', 'like', '%'.$search.'%');
                break;
        }
        $books = $books->paginate(config('define.books.limit_rows'));
        return view('backend.books.index', compact('books'));
    }

    /**
     * Show form edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('backend.books.edit');
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
        // create book.
        $book = new Book($request->except(['total_rating', 'rating', 'is_printed']));
        
        // save book picture
        if ($request->hasFile('picture')) {
            $picture = $request->picture;
            $folderStore = config('define.books.folder_store');
            $pictureName = config('define.books.name_prefix') . '-' . $picture->hashName();
            $picturePath = $folderStore . $pictureName;
            $picture->move($folderStore, $pictureName);
            $book->picture = $picturePath;
        } else {
            $book->picture = config('define.books.default_image');
        }

        // generate qrcode
        $qrCode = Book::orderBy('qrcode', 'desc')->first()->qrcode;
        if (!empty($qrCode)) {
            $qrCodeNumber = substr($qrCode, 4);
            $qrCodeNumber = $qrCodeNumber + 1;
            $qrCodeNew = substr($qrCode, 0, strlen($qrCode) - strlen($qrCodeNumber)) . $qrCodeNumber;
            $book->qrcode = $qrCodeNew;
        } else {
            $book->qrcode = config('define.books.default_qrcode');
        }

        // get unit field
        $book->unit = trans('books.listunit')[$request->unit];

        if ($book->save()) {
            $request->session()->flash('create_success', trans('books.create_success'));
            return redirect()->route('books.index');
        } else {
            $request->session()->flash('create_failure', trans('books.create_failure'));
            return redirect()->back()->withInput();
        }
    }
}

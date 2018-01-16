<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditBookRequest;
use App\Http\Requests\Backend\CreateBookRequest;
use DB;
use App\Model\Book;
use App\Model\Qrcode;
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

        // check filter when search
        switch ($filter) {
            case Book::TYPE_TITLE:
                $books = Book::where('title', 'like', '%'.$search.'%');
                break;
            case Book::TYPE_AUTHOR:
                $books = Book::where('author', 'like', '%'.$search.'%');
                break;
            default:
                $books = Book::where('title', 'like', '%'.$search.'%')->orWhere('author', 'like', '%'.$search.'%');
                break;
        }
        
        // get list books
        $books = $books->leftJoin('borrows', 'books.id', '=', 'borrows.book_id')
                 ->select($fields)
                 ->groupBy('books.id')
                 ->orderBy($sort, $order)
                 ->paginate(config('define.books.limit_rows'))
                 ->appends(['sort' => $sort, 'order' => $order]);

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
        // create book.
        $book = new Book($request->except(['total_rating', 'rating']));

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

        // get unit field
        $book->unit = trans('books.listunit')[$request->unit];


        if ($book->save()) {
            // generate qrcode_id
            $qrCode = Qrcode::orderBy('code_id', 'desc')->first();
            if (!empty($qrCode)) {
                $code_id = $qrCode->code_id + 1;
            } else {
                $code_id = Qrcode::DEFAULT_CODE_ID;
            }

            // save qrcode
            $book->qrcodes()->save(
                new Qrcode([
                    'code_id' => $code_id,
                    'prefix' => Qrcode::DEFAULT_CODE_PREFIX,
                ])
            );

            $request->session()->flash('create_success', __('books.create_success'));
            return redirect()->route('books.index');
        } else {
            $request->session()->flash('create_failure', __('books.create_failure'));
            return redirect()->back()->withInput();
        }
    }
}

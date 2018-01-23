<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditBookRequest;
use App\Http\Requests\Backend\CreateBookRequest;
use DB;
use Exception;
use App\Model\Book;
use App\Model\Category;
use App\Model\User;
use App\Libraries\Image;

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
        // $search = $request->search;
        // $filter = $request->filter;
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
        $books = Book::search(request('search'), request('filter'))
            ->select($fields)
            ->groupBy('books.id')
            ->orderby($sort, $order);
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
        $books = $books->paginate(config('define.books.limit_rows'))
                        ->appends([
                        'userid' => $userId,
                        'option' => $option,
                        'sort' => $sort,
                        'order' => $order,
                        'search' => request('search')
                        ]);
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
     * @return void
     */
    public function update(EditBookRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        DB::beginTransaction();
        try {
            $this->updateBook($book, $request);
            flash(__('books.books_edit_success'))->success();
            DB::commit();
            return redirect()->route("books.index");
        } catch (Exception $e) {
            flash(__('books.books_edit_failed'))->error();
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Save infomation of Book.
     *
     * @param App\Model\Book                    $book    pass book object
     * @param App\Http\Requests\EditBookRequest $request picture and iddonator edit book
     *
     * @return void
     */
    private function updateBook($book, $request)
    {
        if (isset($request->picture)) {
            $oldPath = $book->picture;
            $book->picture  = Image::update($request->picture, config('image.book.path'), $oldPath);
        }

        $user = User::where('employ_code', $request->iddonator)->first();
        if (isset($user)) {
            $book->from_person = $request->iddonator;
        }
        $book->update($request->except(['iddonator', 'picture']));
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
        // create book fields.
        $bookFields = $request->all();
        $bookFields['unit'] =  __('books.listunit')[$request->unit];
        // save book picture
        if ($request->hasFile('picture')) {
            $picture = $request->picture;
            $folderStore = config('define.books.folder_store_books');
            $pictureName = config('define.books.image_name_prefix') . '-' . $picture->hashName();
            $picture->move($folderStore, $pictureName);
            $bookFields['picture'] = $pictureName;
        } else {
            $bookFields['picture'] = config('define.books.default_name_image');
        }
        DB::beginTransaction();
        try {
            // store book
            $book = Book::create($bookFields);
            // generate qrcode_id
            $qrCode = Qrcode::orderBy('code_id', 'desc')->first();
            $codeNumber = $qrCode ? $qrCode->code_id + 1 :  Qrcode::DEFAULT_CODE_ID ;
            // store qrcode
            $book->qrcode()->create([
                'code_id' => $codeNumber,
                'prefix'  => Qrcode::DEFAULT_CODE_PREFIX,
            ]);
            DB::commit();
            flash(__('books.create_success'))->success();
            return redirect()->route('books.index');
        } catch (\Exception $e) {
            if (isset($pictureName) && \File::exists($folderStore.$pictureName)) {
                \File::delete($folderStore.$pictureName);
            }
            DB::rollback();
            flash(__('books.create_failure'))->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Delete a book and relationship.
     *
     * @param Book $book object book
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        DB::beginTransaction();
        try {
            $book->delete();
            DB::commit();
            flash(__('books.delete_book_success'))->success();
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('books.delete_book_fail'))->error();
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EditBookRequest;
use App\Http\Requests\Backend\CreateBookRequest;
use App\Http\Requests\Backend\ImportBookRequest;
use Excel;
use DB;
use Exception;
use App\Model\Book;
use App\Model\Qrcode;
use App\Model\Category;
use App\Model\Language;
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
        $fields = [
            'books.id',
            'books.title',
            'books.author',
            'books.rating',
            DB::raw('COUNT(borrows.id) AS total_borrowed'),
        ];

        $books = Book::search(request('search'), request('filter'))
            ->select($fields)
            ->with('qrcode')
            ->sortable()
            ->groupBy('books.id')
            ->orderby('books.id', 'desc');
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
            case Book::TYPE_DONATED:
                $books = $books->join('users', 'users.employ_code', '=', 'books.from_person')
                               ->where('users.id', '=', $userId);
                break;
        }
        $books = $books->paginate(config('define.books.limit_rows'));
        
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
        $languages = Language::select('id', 'language')->get();
        return view('backend.books.edit', compact('book', 'categories', 'languages'));
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
            $oldPath = null;

            $oldPicture = Book::checkDefaultImage($book->picture);

            if ($oldPicture) {
                $oldPath = config('image.book.path') . $oldPicture;
            }

            $book->picture  = Image::update($request->picture, config('image.book.path'), $oldPath);
        }

        $book->update($request->except('picture'));
    }

    /**
     * Show the form for creating a new book.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id', 'title')->get();
        $languages = Language::select('id', 'language')->get();
        return view('backend.books.create', compact('categories', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBookRequest $request send request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBookRequest $request)
    {
        // create book fields.
        $bookFields = $request->all();

        // save book picture
        if ($request->hasFile('picture')) {
            $bookFields['picture'] = Image::update($request->picture, config('image.book.path'));
        } else {
            $bookFields['picture'] = config('image.book.default_name_image');
        }
        DB::beginTransaction();
        try {
            // store book
            $book = Book::create($bookFields);
            // generate qrcode_id
            $qrCode = Qrcode::where('prefix', Qrcode::DEFAULT_CODE_PREFIX)
                        ->orderBy('code_id', 'desc')->first();
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
            $picture = Book::checkDefaultImage($book->picture);
            if ($picture) {
                Image::delete(config('image.book.path') . $picture);
            }
            $book->delete();
            DB::commit();
            flash(__('books.delete_book_success'))->success();
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('books.delete_book_fail'))->error();
        }
        return redirect()->back();
    }

    /**
     * Load vcs file and save list into db
     *
     * @param Request $request get request
     *
     * @return \Illuminate\Http\Response
     */
    public function import(ImportBookRequest $request)
    {
        DB::beginTransaction();

        try {
            Excel::load($request->file('file'), function ($reader) {
                $reader->ignoreEmpty()->each(function ($cell) {
                    $this->addBookImport($cell->toArray());
                });
            });
            DB::commit();
            flash(__('books.import_book_success'))->success();
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('books.import_book_fail'))->error();
        }
    }
    
    /**
     * Insert list into db
     *
     * @param array $attributes attribute list
     *
     * @return void
     */
    public function addBookImport($attributes)
    {
        // Create user if not exits
        $user = User::select(['id', 'employ_code'])->where('employ_code', $attributes['employee_code'])->first();
        $employeeCode = ($attributes['employee_code'] != "NULL") ? $attributes['employee_code'] : User::DEFAULT_EMPLOYEE_CODE;
        if (!$user) {
            User::saveImportUser($employeeCode);
        }

        $book = $this->getAttributesBook($attributes);

        // Create book and qrcode
        $qrcodeList = explode(',', $attributes['qrcode']);
        for ($i = 0, $length = count($qrcodeList); $i < $length; $i++) {
            $this->updateOrCreateBook(trim($qrcodeList[$i], ' '), $book);
        }
    }

    /**
     * Insert book and qrcode into db
     *
     * @param string         $qrCode qrcode
     * @param App\Model\Book $book   book
     *
     * @return void
     */
    public function updateOrCreateBook($qrCode, $book)
    {
        $prefix = substr($qrCode, 0, 4);
        $codeId = substr($qrCode, 4);
        
        $qrcodedata = Qrcode::withTrashed()->where([['prefix', $prefix], ['code_id', $codeId]])->first();
        if (!$qrcodedata) {
            $bookdata = Book::lockForUpdate()->create($book);
            Qrcode::saveImportQRCode($prefix, $codeId, $bookdata);
        } else {
            Book::withTrashed()->lockForUpdate()->where(['id' => $qrcodedata->book_id])->update($book);
        }
    }

    /**
     * Get attributes book
     *
     * @param array $attributes attribute list
     *
     * @return void
     */
    public function getAttributesBook($attributes)
    {
        $book = [
            'title'       => $attributes['name'],
            'category_id' => Category::lockForUpdate()->firstOrCreate(['title' => $attributes['category']])->id,
            'description' => isset($attributes['description']) ? '<p>' . $attributes['description'] . '</p>' : Book::DEFAULT_DESCRIPTION,
            'year'        => isset($attributes['year']) ? $attributes['year'] : Book::DEFAULT_YEAR,
            'author'      => isset($attributes['author']) ? $attributes['author'] : Book::DEFAULT_AUTHOR,
            'language_id' => Language::lockForUpdate()->firstOrCreate(['language' => $attributes['language']])->id,
            'page_number' => isset($attributes['pages']) ? $attributes['pages'] : Book::DEFAULT_PAGE_NUMBER,
            'price'       => Book::DEFAULT_PRICE,
            'unit'        => Book::DEFAULT_UNIT,
            'picture'     => config('define.books.default_name_image'),
            'from_person' => ($attributes['employee_code'] != "NULL") ? $attributes['employee_code'] : User::DEFAULT_EMPLOYEE_CODE,
            'status'      => (isset($attributes['status']) && $attributes['status'] == 'available') ? 1 : 0,
        ];
        return $book;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditBookRequest;
use App\Model\Book;
use App\Model\Category;

class BookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.books.index');
    }

    /**
     * Get categoryFields.
     *
     * @param int $id call category have id = $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoryFields = [
             'id',
             'title'
         ];
         $book = Book::findOrFail($id);
         $categories = Category::select($categoryFields)->get();
         return view('backend.books.edit', compact('book', 'categories'));
    }

    /**
     * Request form edit.
     *
     * @param App\Http\Requests\EditBookRequest $request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EditBookRequest $request)
    {
        dd($request);
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

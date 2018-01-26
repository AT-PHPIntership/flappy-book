<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Category;
use App\Model\Book;

class CategoryController extends Controller
{
    /**
     * Display a listing of the category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'categories.id',
            'categories.title',
            DB::raw('COUNT(DISTINCT(books.id)) AS total_books'),
        ];
        $categories = Category::select($fields)
            ->leftJoin('books', 'books.category_id', '=', 'categories.id')
            ->groupBy('categories.id')
            ->paginate(config('define.categories.limit_rows'));

        return view('backend.categories.index', ['categories' => $categories]);
    }
}

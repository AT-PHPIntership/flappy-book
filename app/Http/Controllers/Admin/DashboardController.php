<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\User;
use App\Model\Book;
use App\Model\Borrow;
use App\Model\Category;
use App\Model\Post;

class DashboardController extends Controller
{
    /**
     * Return the view index page.
     *
     * @return view
    */
    public function index()
    {
        $users = User::count();
        $books = Book::count();
        $borrows = Borrow::where('borrows.status', Borrow::BORROWING)->count();
        $categories = Category::count();
        $posts = Post::count();
        $fields = [
            'books.title',
            DB::raw('COUNT(borrows.book_id) AS total_borrowed'),
        ];
        $topBorrowed = Borrow::select($fields)
                             ->join('books', 'books.id', '=', 'borrows.book_id')
                             ->groupBy('books.id')
                             ->orderBy('total_borrowed', 'desc')
                             ->limit(5)
                             ->get();
        return view('backend.home.index', compact(
            'users',
            'books',
            'borrows',
            'categories',
            'posts',
            'topBorrowed'
        ));
    }
}

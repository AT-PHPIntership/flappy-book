<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Book;
use Exception;
use DB;

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

    /**
     * Delete a category and return book to category default.
     *
     * @param Category $category object category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Can't delete default category
        if ($category->id == Category::CATEGORY_DEFAULT) {
            flash(__('categories.can_not_delete_default_category'))->warning();
            return redirect()->back();
        }
        $title = $category->title;
        try {
            $category->delete();
            flash(__('categories.delete_category_success', ['name' => $title]))->success();
        } catch (Exception $e) {
            \Log::error($e);
            flash(__('categories.delete_category_fail', ['name' => $title]))->error();
        }
        return redirect()->back();
    }

    /**
     * Update infomation of Category.
     *
     * @param Illuminate\Http\Request $request category title
     * @param Integer                 $id      category id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        DB::beginTransaction();
        try {
            $category->update($request->only('title'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}

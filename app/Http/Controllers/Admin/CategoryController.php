<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Backend\EditCategoryRequest;
use App\Http\Controllers\Controller;
use App\Model\Category;
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
        return view('backend.categories.index');
    }

    /**
     * Update infomation of Category.
     *
     * @param App\Http\Requests\Backend\EditCategoryRequest $request category request
     * @param Integer                                       $id      category id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditCategoryRequest $request, $id)
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

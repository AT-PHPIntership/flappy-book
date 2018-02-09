<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\Category;
use Illuminate\Http\Response;

class CategoryController extends ApiController
{
    /**
     * Get a listing of the category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'id',
            'title',
        ];
        $categories = Category::select($fields)->get();
        return $this->showAll($categories);
    }
}

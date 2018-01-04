<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditBookRequest;

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
     * Show form edit.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('backend.books.edit');
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

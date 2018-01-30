<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.posts.index');
    }
    
    /**
     * Display a detail of the post.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('backend.posts.show');
    }
}

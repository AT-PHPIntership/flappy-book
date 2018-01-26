<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{


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

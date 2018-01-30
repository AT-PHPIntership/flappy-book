<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = [
            'posts.id',
            'users.name',
            'posts.status',
            'posts.content',
            'posts.created_at',
        ];
        $posts = Post::leftJoin('users', 'posts.user_id', '=', 'users.id')
                    ->select($fields)
                    ->withCount('comments')
                    ->paginate(config('define.posts.limit_rows'));
        return view('backend.posts.index', compact('posts'));
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

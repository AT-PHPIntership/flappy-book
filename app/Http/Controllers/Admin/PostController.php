<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Model\Post;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
     * @param int $id id of post
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $fields = [
            'posts.id',
            'posts.content',
            'posts.status',
            'users.name',
            'users.team',
            'users.avatar_url',
            'ratings.rating',
            'books.title',
            DB::raw('COUNT(likes.id) AS likes'),
            DB::raw('DATE_FORMAT(posts.created_at, "%h:%i:%p %d-%m-%Y") AS create_date'),
        ];

        $post = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftJoin('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->groupBy('posts.id', 'ratings.id')
                    ->findOrFail($id);
        $fieldsComment = [
            'id',
            'comment',
            'parent_id',
            'created_at',
        ];
        $comments = Comment::select($fieldsComment)
                            ->with('comments')
                            ->where('commentable_type', '=', Post::COMMENTABLE_TYPE)
                            ->where('commentable_id', '=', $id)
                            ->where('parent_id', '=', null)
                            ->paginate(config('define.posts.limit_rows_comment'));
 
        return view('backend.posts.show', compact('post', 'comments'));
    }
}

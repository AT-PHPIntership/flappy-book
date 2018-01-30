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
     * Display a detail of the post.
     *
     * @param int $id object book
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $fields = [
            'users.id AS user_id',
            'users.name',
            'users.team',
            'users.avatar_url',
            'posts.id AS book_id',
            'posts.content',
            'posts.status',
            'posts.created_at',
            DB::raw('COUNT(post_id) AS likes'),
        ];
        $post = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->groupBy('posts.id')
                    ->findOrFail($id);
        $fieldsComment = [
            'id',
            'comment',
            'parent_id',
            'created_at',
        ];
        $comments = Comment::select($fieldsComment)
                          ->where('commentable_type', '=', 'post')
                          ->where('commentable_id', '=', $id)
                          ->paginate(config('define.posts.limit_rows_comment'));
        return view('backend.posts.show', compact('post', 'comments'));
    }
}

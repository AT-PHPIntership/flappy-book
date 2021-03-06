<?php

namespace App\Http\Controllers\Admin;

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

        $comments = $post->comments;
 
        return view('backend.posts.show', compact('post', 'comments'));
    }

    /**
     * Delete a post and relationship.
     *
     * @param Post    $post    object post
     * @param Request $request request page
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Request $request)
    {
        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
            flash(__('posts.delete_post_success'))->success();
            return redirect()->route('posts.index', ['page' => $request->page ?? 1]);
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('posts.delete_post_fail'))->error();
            return redirect()->back();
        }
    }
}

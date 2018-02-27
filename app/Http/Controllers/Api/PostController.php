<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Response;
use App\Model\Post;
use DB;

class PostController extends ApiController
{

    /**
     * Get a listing of the status of user.
     *
     * @param int $id id of user
     *
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $fields = [
            'posts.id',
            'posts.user_id',
            'posts.content',
            'posts.status',
            'users.name',
            'books.picture',
            'books.title',
            'ratings.rating',
            DB::raw('COUNT(likes.id) AS likes'),
            DB::raw('DATE_FORMAT(posts.created_at, "%h:%i:%p %d-%m-%Y") AS create_date'),
        ];
        $posts =  Post::filter(request('status'))
                    ->select($fields)
                    ->where('posts.user_id', $id)
                    ->groupBy('posts.id', 'ratings.id')
                    ->paginate(config('define.posts.limit_rows_status'));

        return $this->responsePaginate($posts);
    }
    
    /**
     * Get list of the resource.
     *
     * @param int $id id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews(int $id)
    {
        $fields = [
            'posts.id',
            'posts.content',
            'users.name',
            'users.team',
            'users.avatar_url',
            'ratings.rating',
            DB::raw('COUNT(likes.id) AS likes'),
            'posts.created_at',
            'posts.updated_at',
            'posts.deleted_at',
        ];

        $posts = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->join('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->join('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->where('books.id', '=', $id)
                    ->groupBy('posts.id')
                    ->paginate(config('define.posts.limit_rows'));

        return $this->responsePaginate($posts);
    }
}

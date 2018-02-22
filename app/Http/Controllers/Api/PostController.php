<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
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
        $posts = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftJoin('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->where('posts.user_id', $id)
                    ->groupBy('posts.id', 'ratings.id')
                    ->get();

        return $this->showAll($posts);
    }
}

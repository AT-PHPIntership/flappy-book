<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Model\Post;

class PostController extends ApiController
{

    /**
     * Get a listing of the posts of user.
     *
     * @param Request $request send request
     * @param int     $userId  id of user
     *
     * @return \Illuminate\Http\Response
    */
    public function getPostsOfUser(Request $request, $userId)
    {
        $posts = Post::getPosts($request)
                    ->where('posts.user_id', $userId)
                    ->paginate(config('define.posts.limit_rows_posts_of_user'));

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

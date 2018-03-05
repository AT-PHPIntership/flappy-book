<?php

namespace App\Service;

use DB;
use App\Model\Post;
use Illuminate\Http\Request;

class PostService
{
    
    /**
     * Get list of the resource.
     *
     * @param Request $request send request
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public static function getPosts(Request $request = null)
    {
        $fields = [
            'posts.id',
            'posts.user_id',
            'posts.content',
            'posts.status',
            'users.name',
            'users.team',
            'users.avatar_url',
            'users.is_admin',
            'books.picture',
            'books.title',
            'ratings.book_id',
            'ratings.rating',
            DB::raw('COUNT(likes.id) AS likes'),
            'posts.created_at',
            'posts.updated_at',
        ];
        $params = $request ? $request->all() : null;
        $posts = Post::filter($params)
                    ->select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftjoin('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->groupBy('posts.id');

        return $posts;
    }
}

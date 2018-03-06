<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Service\PostService;
use App\Model\Post;

class PostController extends ApiController
{

    /**
     * Get a list of the posts of user.
     *
     * @param Request $request send request
     * @param int     $userId  id of user
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostsOfUser(Request $request, $userId)
    {
        $posts = PostService::getPosts($request)
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
        $posts = PostService::getPosts()
            ->where('posts.status', Post::TYPE_REVIEW_BOOK)
            ->where('books.id', $id)
            ->paginate(config('define.posts.limit_rows'));

        return $this->responsePaginate($posts);
    }
}

<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Model\Post;
use DB;

class PostController extends ApiController
{
    /**
     * Get list of the resource.
     *
     * @param int $id id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews(int $id)
    {
        $posts = Post::getPosts()
                     ->where('posts.status', Post::TYPE_REVIEW_BOOK)
                     ->where('books.id', $id)
                     ->paginate(config('define.posts.limit_rows'));

        return $this->responsePaginate($posts);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Service\PostService;
use App\Model\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\PostTransformer;
use League\Fractal\Manager;
use App\Model\Rating;
use App\Http\Requests\Api\CreatePostRequest;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Handler;
use Exception;
use DB;

class PostController extends ApiController
{
    /**
     * PostController construct
     *
     * @param Manager         $fractal     fractal
     * @param PostTransformer $transformer transformer
     *
     * @return void
     */
    public function __construct(Manager $fractal, PostTransformer $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

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

    /**
     * Store new resource
     *
     * @param CreatePostRequest $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $request['user_id'] = Auth::id();

        DB::beginTransaction();
        try {
            // Create post
            $post = Post::create($request->all());

            // Create rating when post's status is review
            if ($request->status == Post::TYPE_REVIEW_BOOK) {
                Rating::create([
                        'post_id' => $post->id,
                        'book_id' => $request->book_id,
                        'rating' => $request->rating,
                    ]);
            }
            DB::commit();

            $post = $this->getItem($post, $this->transformer, 'user,rating');
            return $this->responseSuccess($post, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            throw new ModelNotFoundException();
        }
    }

    /**
     * Delete a post and relationship.
     *
     * @param Post $post object post
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->delete();
            DB::commit();
            return $this->responseDeleteSuccess(Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            throw new ModelNotFoundException();
        }
    }
}

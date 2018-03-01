<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Rating;
use App\Http\Requests\Api\CreatePostRequest;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\Handler;
use Exception;
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
                    ->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftjoin('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->where('books.id', '=', $id)
                    ->groupBy('posts.id')
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
            return $this->responseObject($post, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}

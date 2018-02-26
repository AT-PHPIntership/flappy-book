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
                    ->get();

        return $this->showAll($posts);
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
        $request['user_id'] = 1;

        DB::beginTransaction();
        try {
            $post = Post::create($request->all());
            if ($request->status == Post::TYPE_REVIEW_BOOK) {
                Rating::create([
                    'post_id' => $post->id,
                    'book_id' => $request->book_id,
                    'rating' => $request->rating,
                ]);
            }
            DB::commit();
            return $this->show($post->id);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Show detail post
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
            'users.is_admin',
            'ratings.rating',
            'ratings.book_id',
            DB::raw('COUNT(likes.id) AS likes'),
            'posts.created_at',
            'posts.updated_at',
            'posts.deleted_at',
        ];

        $post = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->where('posts.id', '=', $id)
                    ->groupBy('posts.id')
                    ->first();

        return $this->showOne($post);
    }
}

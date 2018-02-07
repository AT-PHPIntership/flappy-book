<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Book;
use App\Model\Post;
use App\Model\Comment;
use DB;

class PostController extends Controller
{
    /**
     * The Book implementation.
     *
     * @var Book
     */
    protected $posts;

    /**
     * Create a new controller instance.
     *
     * @param Post $posts instance of Post
     */
    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get list of the resource.
     *
     * @param int $id id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function reviews(int $book_id)
    {
        $fields = [
            'posts.id',
            'posts.content',
            'users.name',
            'users.team',
            'users.avatar_url',
            'ratings.rating',
            DB::raw('COUNT(likes.id) AS likes'),
            DB::raw('DATE_FORMAT(posts.created_at, "%h:%i:%p %d-%m-%Y") AS create_date'),
        ];

        $posts = Post::select($fields)
                    ->join('users', 'posts.user_id', '=', 'users.id')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->leftJoin('books', 'books.id', '=', 'ratings.book_id')
                    ->leftJoin('likes', 'posts.id', '=', 'likes.post_id')
                    ->where('books.id', '=', $book_id)
                    ->groupBy('posts.id', 'ratings.id')
                    ->paginate(config('define.posts.limit_rows'));

        return response()->json([
            'meta' => [
                'status' => 'successful',
                'code' => 200
            ],
            'data' => $posts
        ], Response::HTTP_OK);
    }
}

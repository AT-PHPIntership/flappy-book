<?php

namespace App\Transformers;

use App\Model\Post;
use App\Model\Rating;
use App\Model\Like;
use App\Model\Book;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\App;

class PostTransformer extends TransformerAbstract
{
    /**
     * The attributes that are available include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user',
        'book',
        'rating'
    ];

    /**
     * The attributes that are default include.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'like',
    ];

    /**
     * Transform
     *
     * @param Post $post post
     *
     * @return Array
     */
    public function transform(Post $post)
    {
        return [
            'id' => (int) $post->id,
            'content' => (string) $post->content,
            'status' => (int) $post->status,
            'user_id' => (int) $post->user_id,
            'created_at' => (string) $post->created_at,
            'updated_at' => (string) $post->updated_at
        ];
    }

    /**
     * Transform
     *
     * @param Post $post post
     *
     * @return Item
     */
    public function includeUser(Post $post)
    {
        return $this->item($post->users, App::make(UserIncludeTransformer::class));
    }

    /**
     * Transform
     *
     * @param Post $post post
     *
     * @return Item
     */
    public function includeRating(Post $post)
    {
        $rating = Rating::where('post_id', $post->id)->first();

        if (!$rating) {
            return $this->null();
        }
        return $this->item($rating, App::make(RatingTransformer::class));
    }

    /**
     * Transform
     *
     * @param Post $post post
     *
     * @return Item
     */
    public function includeLike(Post $post)
    {
        $likes = Like::where('post_id', $post->id)->count();

        return $this->item($likes, function ($likes) {
            return ['likes' => $likes];
        });
    }

    /**
     * Transform
     *
     * @param Post $post post
     *
     * @return Item
     */
    public function includeBook(Post $post)
    {
        $rating = Rating::where('post_id', $post->id)->first();

        if (!$rating) {
            return $this->null();
        }
        return $this->item($rating->books, App::make(BookIncludeTransformer::class));
    }
}

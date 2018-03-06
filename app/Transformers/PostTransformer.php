<?php

namespace App\Transformers;

use App\Model\Post;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Support\Facades\App;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user',
        'rating'
    ];

    public function transform(Post $post)
    {
        return [
            'id' => (int)$post->id,
            'content' => (string)$post->content,
            'status' => (int)$post->status,
            'created_at' => (string)$post->created_at,
            'updated_at' => (string)$post->updated_at
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->users, App::make(UserTransformer::class));
    }

    public function includeRating(Post $post)
    {
        if (!$post->rating) {
            return null;
        }

        return $this->item($post->rating, App::make(RatingTransformer::class));
    }
}

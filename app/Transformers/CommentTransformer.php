<?php

namespace App\Transformers;

use App\Model\Comment;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Support\Facades\App;

class CommentTransformer extends TransformerAbstract
{
    /**
     * The attributes that are available include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user',
    ];

    /**
     * Transform
     *
     * @param Comment $comment Comment
     *
     * @return Array
     */
    public function transform(Comment $comment)
    {
        return [
            'id' => (int) $comment->id,
            'comment' => (string) $comment->comment,
            'commentable_id' => (int) $comment->commentable_id,
            'commentable_type' => (string) $comment->commentable_type,
            'parent_id' => $comment->parent_id,
            'user_id' => (int) $comment->user_id,
            'created_at' => (string) $comment->created_at,
            'updated_at' => (string) $comment->updated_at,
        ];
    }

    /**
     * Transform
     *
     * @param Comment $comment Comment
     *
     * @return Item
     */
    public function includeUser(Comment $comment)
    {
        return $this->item($comment->users, App::make(UserTransformer::class));
    }
}

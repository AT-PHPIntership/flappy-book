<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Http\Requests\Api\GetCommentsRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\CreateCommentRequest;
use Illuminate\Support\Facades\Auth;
use App\Transformers\CommentTransformer;
use League\Fractal\Manager;
use App\Model\Comment;

class CommentController extends ApiController
{
    /**
     * PostController construct
     *
     * @param Manager         $fractal     fractal
     * @param PostTransformer $transformer transformer
     *
     * @return void
     */
    public function __construct(Manager $fractal, CommentTransformer $transformer)
    {
        $this->fractal = $fractal;
        $this->transformer = $transformer;
    }

    /**
     * Get list of the resource.
     *
     * @param GetCommentsRequest $request request of comment
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(GetCommentsRequest $request)
    {
        $fields = [
            'comments.id',
            'comments.comment',
            'comments.commentable_id',
            'comments.commentable_type',
            'users.name',
            'users.team',
            'users.avatar_url',
            'users.is_admin',
            'comments.parent_id',
            'comments.created_at',
            'comments.updated_at',
            'comments.deleted_at',
        ];

        $comments = Comment::select($fields)
                           ->join('users', 'comments.user_id', '=', 'users.id')
                           ->where('commentable_id', $request->commentable_id)
                           ->where('commentable_type', $request->commentable_type)
                           ->paginate(config('define.comments.limit_rows'))
                           ->appends($request->except('page'));

        return $this->responsePaginate($comments);
    }

    /**
     * Store new resource
     *
     * @param CreatePostRequest $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request)
    {
        $request['user_id'] = Auth::id();
        $comment = Comment::create($request->all());
        $comment = $this->getItem($comment, $this->transformer, 'user');
        return $this->responseSuccess($comment, Response::HTTP_CREATED);
    }
}

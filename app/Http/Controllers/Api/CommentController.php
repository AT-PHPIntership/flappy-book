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
     * CommentController construct
     *
     * @param Manager            $fractal     fractal
     * @param CommentTransformer $transformer transformer
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
        $comments = Comment::join('users', 'comments.user_id', 'users.id')
                           ->where('commentable_id', $request->commentable_id)
                           ->where('commentable_type', $request->commentable_type)
                           ->paginate(config('define.comments.limit_rows'))
                           ->appends($request->except('page'));

        $comments = $this->transformerResource($comments, ['user']);
        return $this->responseResource($comments);
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

        $comment = $this->transformerResource($comment, ['user']);
        return $this->responseSuccess($comment, Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\CreateCommentRequest;
use App\Model\Comment;
use DB;

class CommentController extends ApiController
{
/**
     * Store new resource
     *
     * @param CreatePostRequest $request request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request)
    {
        // dd($request->all());
        $request['user_id'] = 1;
        
        DB::beginTransaction();
        try {
            $comment = Comment::create($request->all());
            DB::commit();
            return $this->showOne($comment);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Http\Response;
use Exception;
use DB;

class CommentController extends Controller
{
    /**
     * Delete a comment and relationship.
     *
     * @param Comment $comment object comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->delete();
            DB::commit();
            return response()->json(__('comments.delete_comment_success'), Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollback();
            \Log::error($e);
            return response()->json(__('comments.delete_comment_fail'), Response::HTTP_NOT_FOUND);
        }
    }
}

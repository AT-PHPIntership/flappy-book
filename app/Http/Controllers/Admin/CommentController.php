<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Http\Response;

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
        $result = $comment->delete();
        if ($result) {
            return response()->json(__('comments.delete_comment_success'), Response::HTTP_OK);
        }
        return response()->json(__('comments.delete_comment_fail'), Response::HTTP_NOT_FOUND);
    }
}

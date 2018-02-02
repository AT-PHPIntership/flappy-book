<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;
use DB;

class CommentController extends Controller
{
  /**
    * Delete a comment and relationship.
    *
    * @param comment $comment object comment
    *
    * @return \Illuminate\Http\Response
    */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();
            flash(__('common.comment.delete_success'))->success();
        } catch (Exception $e) {
            flash(__('common.comment.delete_failed'))->error();
        }
        return redirect()->back();
    }
}

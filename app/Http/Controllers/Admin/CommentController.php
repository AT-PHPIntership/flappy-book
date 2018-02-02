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
        DB::beginTransaction();
        try {
            $comment->delete();
            DB::commit();
            flash(__('common.delete_comment_success'))->success();
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('common.delete_comment_failed'))->error();
            return redirect()->back();
        }
    }
}

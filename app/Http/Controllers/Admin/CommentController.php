<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Comment;

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
        return response()->json(400, 200);
    }
}

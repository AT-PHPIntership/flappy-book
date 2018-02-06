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
     * @param comment $id object comment
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Comment::findOrFail($id)->delete();
            if (request()->ajax()) {
                return response()->json(Response::HTTP_NO_CONTENT);
            }
        } catch (Exception $e) {
            return response()->json(Response::HTTP_NOT_FOUND);
        }
    }
}

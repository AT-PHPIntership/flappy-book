<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
	/**
     * Delete a post and relationship.
     *
     * @param Post $post object post
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->delete();
            dd($post->delete());
            DB::commit();
            flash(__('post.delete_post_success'))->success();
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('post.delete_post_fail'))->error();
        	return redirect()->back();
        }
        return redirect()->route('post.index');
    }
}

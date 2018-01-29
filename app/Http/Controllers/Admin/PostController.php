<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use DB;

class PostController extends Controller
{
    /**
     * Display a detail of the post.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('backend.posts.show');
    }

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
            DB::commit();
            flash(__('posts.delete_post_success'))->success();
            return redirect()->route('post.index');
        } catch (Exception $e) {
            DB::rollBack();
            flash(__('posts.delete_post_fail'))->error();
            return redirect()->back();
        }
    }
}

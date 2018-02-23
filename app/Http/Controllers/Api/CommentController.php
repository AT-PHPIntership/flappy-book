<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Model\Comment;
use App\Model\Book;
use DB;

class CommentController extends ApiController
{
	/**
     * Get list of the resource.
     *
     * @param int $id id of book
     *
     * @return \Illuminate\Http\Response
     */
    public function commentsOfBook(int $id)
    {
        $fields = [
            'comments.id',
            'comments.comment',
            'users.name',
            'users.team',
            'users.avatar_url',
            'users.is_admin',
            'comments.parent_id',
            'comments.created_at',
            'comments.updated_at',
            'comments.deleted_at',
        ];

        $comments = Book::findOrFail($id)
                          ->comments()
                          ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                          ->select($fields)
                          ->get();

        return $this->showAll($comments);
    }
}

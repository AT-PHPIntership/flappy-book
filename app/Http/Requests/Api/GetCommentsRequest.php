<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Model\Comment;

class GetCommentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'commentable_type' => 'required|in:'.Comment::BOOK_TYPE.','
                                                .Comment::POST_TYPE,
            'commentable_id'   => 'required|integer'
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Model\Post;

class CreatePostRequest extends FormRequest
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
     * @param Request $request request for add post
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'status'  => 'required|in:'.Post::TYPE_STATUS.','
                                       .Post::TYPE_FIND_BOOK.','
                                       .Post::TYPE_REVIEW_BOOK,
            'content' => 'required|min:10',
        ];

        if ($request->status == Post::TYPE_REVIEW_BOOK) {
            $rules = array_merge($rules, [
                'rating'  => 'required|integer',
                'book_id' => 'required|exists:books,id',
            ]);
        }

        return $rules;
    }

    /**
     * Response messages when failed validation
     *
     * @param Validator $validator validator
     *
     * @return \Illuminate\Http\Response
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'meta' => [
                'status' => __('api.failured'),
                'code' => 422
            ],
            'error' => [
                'message' => $validator->errors()
            ]
        ], 422));
    }
}

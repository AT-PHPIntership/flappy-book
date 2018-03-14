<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Model\Post;

class UpdatePostRequest extends FormRequest
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
        $typePost = $request->route('post')->status;
        $rules = [
            'content' => 'required|min:10',
        ];
        if (($typePost == Post::TYPE_REVIEW_BOOK) && isset($request->rating)) {
            $rules = array_merge($rules, [
                'rating'  => 'required|numeric|min:1',
            ]);
        }

        return $rules;
    }
}

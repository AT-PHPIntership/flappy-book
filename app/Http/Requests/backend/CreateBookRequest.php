<?php

namespace App\Http\Requests\backend;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|min:6',
            'category'    => 'required',
            'price'       => 'required|numeric',
            'unit'        => 'required',
            'iddonator'   => 'required',
            'description' => 'required',
            'year'        => 'numeric|min:1000|max:3000',
            'author'      => 'required',
            'picture'     => 'require|image|mimes:png,jpg,jpeg',
        ];
    }
}

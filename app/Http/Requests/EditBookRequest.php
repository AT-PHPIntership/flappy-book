<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBookRequest extends FormRequest
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
            'title' => 'required|min:2',
            'price' => 'required|numberic',
            'from_person' => 'required',
            'description' => 'required|string',
            'year' => 'numberic|date_format:"Y"',
            'author' => 'required',
            'image' => 'image|max:10240',
        ];
    }
}

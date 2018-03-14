<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EditLanguageRequest extends FormRequest
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
     * @param Illuminate\Http\Request $request request for edit language
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'language' => 'required|unique:languages,language,' . $request->get('id'),
        ];
    }
}

<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ImportBookRequest extends FormRequest
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
            'file' => 'required|mimes:csv,txt|max:5000',
        ];
    }

    /**
     * Set validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.mimes' => __('books.validate_file_type'),
        ];
    }
}

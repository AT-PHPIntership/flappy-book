<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Model\Book;

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
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'unit'        => 'in:'.Book::TYPE_VND.','
                                  .Book::TYPE_DOLAR.','
                                  .Book::TYPE_EURO.','
                                  .Book::TYPE_YEN.',',
            'from_person' => 'required|max:10|exists:users,employ_code',
            'description' => 'required',
            'year'        => 'required|date_format:"Y"',
            'author'      => 'required|max:255',
            'picture'     => 'image|mimes:png,jpg,jpeg|dimensions:min_width=100,min_height=200',
        ];
    }
}

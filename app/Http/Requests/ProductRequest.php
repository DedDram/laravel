<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'alias' => 'required|min:3|max:255|unique:products,alias',
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:5',
            'price' => 'required|numeric|min:1'
        ];

        if ($this->route()->named('products.update')) {
            $rules['alias'] .= ',' . $this->route()->parameter('product')->id;
        }

        return $rules;
    }
}

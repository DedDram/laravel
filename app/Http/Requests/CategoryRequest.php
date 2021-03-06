<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'alias' => 'required|min:3|max:255|unique:categories,alias',
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:5',
        ];

        if ($this->route()->named('categories.update')) {
            $rules['alias'] .= ',' . $this->route()->parameter('category')->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для ввода',
            'min' => 'Поле :attribute должно иметь минимум :min символов',
            'alias.min' => 'Поле alias должно содержать не менее :min символов',
            'alias.unique' => 'Поле alias должно быть уникально, данное значение уже есть в базе',
        ];
    }
}

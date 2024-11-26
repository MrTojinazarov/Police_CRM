<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kategoriya nomi kiritish majburiy.',
            'name.string' => 'Kategoriya nomi faqat matn bo\'lishi kerak.',
            'name.max' => 'Kategoriya nomi 255 ta belgidan oshmasligi kerak.',
        ];
    }

}

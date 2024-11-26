<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id', 
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Foydalanuvchi tanlanishi majburiy.',
            'user_id.exists' => 'Tanlangan foydalanuvchi mavjud emas.',
            'name.required' => 'Region nomi kiritish majburiy.',
            'name.string' => 'Region nomi faqat matn bo\'lishi kerak.',
            'name.max' => 'Region nomi 255 ta belgidan oshmasligi kerak.',
        ];
    }
}

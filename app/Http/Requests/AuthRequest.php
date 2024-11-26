<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        if ($this->isMethod('post')) { 
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $this->route('user'),
                'role' => 'nullable|string|max:255',
                'password' => 'nullable|string|min:6|confirmed',
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'Ismni kiritish majburiy.',
            'name.string' => 'Ism faqat matn bo\'lishi kerak.',
            'name.max' => 'Ism 255 ta belgidan oshmasligi kerak.',
            'email.required' => 'Email manzilingizni kiritish majburiy.',
            'email.email' => 'Iltimos, haqiqiy email manzilini kiriting.',
            'email.unique' => 'Bu email manzil avval ro\'yxatga olingan.',
            'password.required' => 'Parolni kiritish majburiy.',
            'password.confirmed' => 'Parol tasdiqlashda xato bor.',
            'password.min' => 'Parol kamida 6 ta belgidan iborat bo\'lishi kerak.',
            'role.string' => 'Ruhsat faqat matn bo\'lishi kerak.',
            'role.max' => 'Ruhsat 255 ta belgidan oshmasligi kerak.',
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'performer' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,docx|max:20480',
            'deadline' => 'required|date',
            'region_ids' => 'required|array|exists:regions,id',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Kategoriya tanlanishi majburiy.',
            'category_id.exists' => 'Tanlangan kategoriya mavjud emas.',
            'title.required' => 'Sarlavha kiritish majburiy.',
            'title.string' => 'Sarlavha faqat matn bo\'lishi kerak.',
            'title.max' => 'Sarlavha 255 ta belgidan oshmasligi kerak.',
            'performer.required' => 'Ijrochi nomi kiritish majburiy.',
            'performer.string' => 'Ijrochi faqat matn bo\'lishi kerak.',
            'performer.max' => 'Ijrochi nomi 255 ta belgidan oshmasligi kerak.',
            'file.file' => 'Fayl tanlanishi kerak.',
            'file.mimes' => 'Faqat jpeg, png, jpg, gif, mp4, mov, avi, pdf, docx formatidagi fayllar ruxsat etilgan.',
            'file.max' => 'Faylning maksimal hajmi 20 MB dan oshmasligi kerak.',
            'deadline.required' => 'Muddat kiritish majburiy.',
            'deadline.date' => 'Muddat to\'g\'ri formatda bo\'lishi kerak.',
            'region_ids.required' => 'Hududlar tanlanishi majburiy.',
            'region_ids.array' => 'Hududlar to\'plami sifatida yuborilishi kerak.',
            'region_ids.exists' => 'Tanlangan hududlar mavjud emas.',
        ];
    }

}

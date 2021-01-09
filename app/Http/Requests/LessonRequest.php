<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'subject' => 'required',
            'grade' => 'required',
            'datetime' => 'required',
            'theme' => 'required|min:3|max:150',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Выберите предмет',
            'grade.required' => 'Выберите класс',
            'datetime.required' => 'Укажите дату и время начала урока',
            'theme.required' => 'Укажите тему урока',
            'description.required' => 'Укажите описание урока',
        ];
    }
}

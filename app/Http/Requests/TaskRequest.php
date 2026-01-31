<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules() {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле title обязательно для заполнения.',
            'title.max' => 'Title не может превышать 255 символов.',
            'status.required' => 'Статус обязателен.',
            'status.in' => 'Допустимые значения статуса: pending, in_progress, completed.',
            'due_date.date_format' => 'Дата должна быть в формате Y-m-d.',
        ];
    }
}

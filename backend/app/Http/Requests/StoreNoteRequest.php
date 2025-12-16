<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:255|min:3',
            'description' => 'required|string|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Поле «Заголовок» обязательно к заполнению',
            'description.required' => 'Поле «Содержимое» обязательно к заполнению',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title'   => trim($this->title),
            'description' => trim($this->description),
        ]);
    }
}

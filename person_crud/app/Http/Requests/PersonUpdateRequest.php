<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'cpf' => 'sometimes|string',
            'birth_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.required' => 'CPF é obrigatório.',
            'birth_date.date_format' => 'Formato de data deve ser YYYY-MM-DD',
        ];
    }
}

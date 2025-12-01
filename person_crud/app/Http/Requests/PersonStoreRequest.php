<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonStoreRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string',
            'birth_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'CPF é obrigatório.',
            'birth_date.date_format' => 'Formato de data deve ser YYYY-MM-DD'
        ];
    }
}

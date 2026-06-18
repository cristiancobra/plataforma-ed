<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanRequest extends FormRequest
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
            'due_date' => 'required|date',
            'returned_date' => 'nullable|date',
            'status' => 'nullable|in:pending,active,returned,overdue,cancelled',
            'notes' => 'nullable|string|max:1000',
            'conditions_on_return' => 'nullable|array',
            'conditions_on_return.*' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'due_date.required' => 'A data de vencimento é obrigatória.',
            'due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'returned_date.date' => 'A data de devolução deve ser uma data válida.',
            'status.in' => 'O status selecionado é inválido.',
        ];
    }
}

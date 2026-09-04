<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
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
            'lender_user_id' => 'required|exists:users,id',
            'borrower_type' => 'required|in:user,contact',
            'borrower_user_id' => 'required_if:borrower_type,user|nullable|exists:users,id',
            'borrower_contact_id' => 'required_if:borrower_type,contact|nullable|exists:contacts,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'destination' => 'nullable|string|max:255',
            'collection_ids' => 'required|array|min:1',
            'collection_ids.*' => 'exists:collections,id',
            'conditions' => 'nullable|array',
            'conditions.*' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
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
            'lender_user_id.required' => 'O emprestador é obrigatório.',
            'lender_user_id.exists' => 'O emprestador selecionado não existe.',
            'borrower_type.required' => 'O tipo de devedor é obrigatório.',
            'borrower_type.in' => 'O tipo de devedor deve ser usuário ou contato.',
            'borrower_user_id.required_if' => 'O usuário devedor é obrigatório quando o tipo é usuário.',
            'borrower_contact_id.required_if' => 'O contato devedor é obrigatório quando o tipo é contato.',
            'start_date.required' => 'A data de empréstimo é obrigatória.',
            'start_date.date' => 'A data de empréstimo deve ser uma data válida.',
            'due_date.required' => 'A data de vencimento é obrigatória.',
            'due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'due_date.after' => 'A data de vencimento deve ser posterior à data de empréstimo.',
            'collection_ids.required' => 'Pelo menos um item deve ser selecionado.',
            'collection_ids.min' => 'Pelo menos um item deve ser selecionado.',
            'collection_ids.*.exists' => 'Um ou mais itens selecionados não existem.',
        ];
    }
}

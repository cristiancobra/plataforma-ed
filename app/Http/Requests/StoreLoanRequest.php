<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $accountId = auth()->user()->account_id;

        return [
            'lender_user_id' => ['required', Rule::exists('users', 'id')->where('account_id', $accountId)],
            'borrower_type' => 'required|in:user,contact',
            'borrower_user_id' => ['required_if:borrower_type,user', 'nullable', Rule::exists('users', 'id')->where('account_id', $accountId)],
            'borrower_contact_id' => ['required_if:borrower_type,contact', 'nullable', Rule::exists('contacts', 'id')->where('account_id', $accountId)],
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'destination' => 'nullable|string|max:255',
            'collection_ids' => 'required|array|min:1',
            'collection_ids.*' => [
                'distinct',
                Rule::exists('collections', 'id')
                    ->where('account_id', $accountId)
                    ->where('status', 'available')
                    ->where('trash', 0),
            ],
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
            'borrower_user_id.exists' => 'O usuário devedor selecionado não existe.',
            'borrower_contact_id.exists' => 'O contato devedor selecionado não existe.',
            'start_date.required' => 'A data de empréstimo é obrigatória.',
            'start_date.date' => 'A data de empréstimo deve ser uma data válida.',
            'due_date.required' => 'A data de vencimento é obrigatória.',
            'due_date.date' => 'A data de vencimento deve ser uma data válida.',
            'due_date.after_or_equal' => 'A data de vencimento não pode ser anterior à data de empréstimo.',
            'collection_ids.required' => 'Pelo menos um item deve ser selecionado.',
            'collection_ids.min' => 'Pelo menos um item deve ser selecionado.',
            'collection_ids.*.exists' => 'Um ou mais itens selecionados não estão mais disponíveis para empréstimo.',
            'collection_ids.*.distinct' => 'Um item foi selecionado mais de uma vez.',
        ];
    }
}

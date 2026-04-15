<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoalRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'department' => 'nullable|string',
            'status' => 'nullable|string',
            'type' => 'required|string|in:execução,contatos,receita,despesa,entrada,saída',
            'date_start' => 'nullable|date',
            'date_due' => 'nullable|date|after_or_equal:date_start',
            'date_conclusion' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Adicionar validação baseada no tipo de meta
        switch ($this->type) {
            case 'contatos':
                $rules['goal_contacts'] = 'required|numeric|min:1';
                break;
            case 'receita':
                $rules['goal_invoices_revenues'] = 'required';
                break;
            case 'despesa':
                $rules['goal_invoices_expenses'] = 'required';
                break;
            case 'entrada':
                $rules['goal_transactions_revenues'] = 'required';
                break;
            case 'saída':
                $rules['goal_transactions_expenses'] = 'required';
                break;
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => '*preenchimento obrigatório.',
            'numeric' => '*o valor deve ser numérico.',
            'min' => '*o valor deve ser maior que zero.',
            'string' => '*deve ser um texto válido.',
            'max' => '*o tamanho máximo é :max caracteres.',
            'date' => '*deve ser uma data válida.',
            'after_or_equal' => '*a data deve ser igual ou posterior à data de início.',
            'in' => '*valor inválido.',
            'image' => '*deve ser uma imagem válida.',
            'mimes' => '*formato de arquivo não suportado.',
        ];
    }

    /**
     * Validação adicional após as regras padrão
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar valores monetários após conversão
            $type = $this->type;
            
            switch ($type) {
                case 'receita':
                    if ($this->goal_invoices_revenues) {
                        $value = removeCurrency($this->goal_invoices_revenues);
                        if (!is_numeric($value) || $value <= 0) {
                            $validator->errors()->add('goal_invoices_revenues', 'O valor da receita deve ser um número válido maior que zero.');
                        }
                    }
                    break;
                case 'despesa':
                    if ($this->goal_invoices_expenses) {
                        $value = removeCurrency($this->goal_invoices_expenses);
                        if (!is_numeric($value) || $value <= 0) {
                            $validator->errors()->add('goal_invoices_expenses', 'O valor da despesa deve ser um número válido maior que zero.');
                        }
                    }
                    break;
                case 'entrada':
                    if ($this->goal_transactions_revenues) {
                        $value = removeCurrency($this->goal_transactions_revenues);
                        if (!is_numeric($value) || $value <= 0) {
                            $validator->errors()->add('goal_transactions_revenues', 'O valor da entrada deve ser um número válido maior que zero.');
                        }
                    }
                    break;
                case 'saída':
                    if ($this->goal_transactions_expenses) {
                        $value = removeCurrency($this->goal_transactions_expenses);
                        if (!is_numeric($value) || $value <= 0) {
                            $validator->errors()->add('goal_transactions_expenses', 'O valor da saída deve ser um número válido maior que zero.');
                        }
                    }
                    break;
            }
        });
    }
}

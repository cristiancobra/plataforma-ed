<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                // nome único apenas dentro da conta (multi-tenant)
                Rule::unique('products', 'name')->where('account_id', auth()->user()->account_id),
            ],
            'price' => ['required', 'regex:/^(R\$\s?)?\d{1,3}(\.?\d{3})*(,\d{1,2})?$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:50000',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'name.required' => '*preenchimento obrigatório.',
            'name.unique' => 'Já existe um produto com este nome.',
            'price.required' => '*preenchimento obrigatório.',
            'price.regex' => 'Informe um preço válido (ex.: 1.234,56).',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
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
            'price.numeric' => 'O preço deve ser um valor numérico.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'site' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'field_of_activity_1' => 'nullable|string|max:255',
            'field_of_activity_2' => 'nullable|string|max:255',
            'field_of_activity_3' => 'nullable|string|max:255',
            'field_of_activity_4' => 'nullable|string|max:255',
            'field_of_activity_5' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:ativo,inativo',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo "Nome" é obrigatório.',
            'name.max' => 'O campo "Nome" não pode ter mais de 255 caracteres.',
            'cnpj.max' => 'O campo "CNPJ" não pode ter mais de 18 caracteres.',
            'email.email' => 'O campo "Email" deve ser um endereço de email válido.',
            'email.max' => 'O campo "Email" não pode ter mais de 255 caracteres.',
            'phone.max' => 'O campo "Telefone" não pode ter mais de 20 caracteres.',
            'site.url' => 'O campo "Site" deve ser uma URL válida.',
            'site.max' => 'O campo "Site" não pode ter mais de 255 caracteres.',
            'instagram.max' => 'O campo "Instagram" não pode ter mais de 255 caracteres.',
            'facebook.max' => 'O campo "Facebook" não pode ter mais de 255 caracteres.',
            'linkedin.max' => 'O campo "LinkedIn" não pode ter mais de 255 caracteres.',
            'twitter.max' => 'O campo "Twitter" não pode ter mais de 255 caracteres.',
            'field_of_activity_1.max' => 'O campo "Área de Atuação 1" não pode ter mais de 255 caracteres.',
            'field_of_activity_2.max' => 'O campo "Área de Atuação 2" não pode ter mais de 255 caracteres.',
            'field_of_activity_3.max' => 'O campo "Área de Atuação 3" não pode ter mais de 255 caracteres.',
            'field_of_activity_4.max' => 'O campo "Área de Atuação 4" não pode ter mais de 255 caracteres.',
            'field_of_activity_5.max' => 'O campo "Área de Atuação 5" não pode ter mais de 255 caracteres.',
            'address.max' => 'O campo "Endereço" não pode ter mais de 255 caracteres.',
            'city.max' => 'O campo "Cidade" não pode ter mais de 255 caracteres.',
            'state.max' => 'O campo "Estado" não pode ter mais de 255 caracteres.',
            'country.max' => 'O campo "País" não pode ter mais de 255 caracteres.',
            'zip_code.max' => 'O campo "CEP" não pode ter mais de 20 caracteres.',
            'type.max' => 'O campo "Tipo" não pode ter mais de 255 caracteres.',
            'status.in' => 'O campo "Status" deve ser "ativo" ou "inativo".',
        ];
    }
}

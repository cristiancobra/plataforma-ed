<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'lead_source' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_birth' => 'nullable|date',
            'cpf' => 'nullable|string|max:14', // Adapte conforme o formato do CPF
            'profession' => 'nullable|string|max:255',
            'companies' => 'nullable|array',
            'companies.*' => 'exists:companies,id',
            'job_position' => 'nullable|string|max:255',
            'schollarity' => 'nullable|string|max:255',
            'usp_id' => 'nullable|string|max:8',
            'area_of_knowledge_1' => 'nullable|string|max:255',
            'area_of_knowledge_2' => 'nullable|string|max:255',
            'area_of_knowledge_3' => 'nullable|string|max:255',
            'area_of_knowledge_4' => 'nullable|string|max:255',
            'area_of_knowledge_5' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'site' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'civil_state' => 'nullable|string|max:255',
            'naturality' => 'nullable|string|max:255',
            'kids' => 'nullable|integer|min:0',
            'hobbie' => 'nullable|string|max:255',
            'income' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'etinicity' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'status' => 'nullable|string|in:ativo,pendente,desativado',
        ];
    }

    public function messages()
    {
        return [
            'lead_source.max' => 'O campo "Origem do Lead" não pode ter mais de 255 caracteres.',
            'first_name.required' => 'O campo "Primeiro Nome" é obrigatório.',
            'first_name.max' => 'O campo "Primeiro Nome" não pode ter mais de 255 caracteres.',
            'last_name.required' => 'O campo "Sobrenome" é obrigatório.',
            'last_name.max' => 'O campo "Sobrenome" não pode ter mais de 255 caracteres.',
            'date_birth.date' => 'O campo "Data de Nascimento" deve ser uma data válida.',
            'cpf.max' => 'O campo "CPF" não pode ter mais de 14 caracteres.',
            'profession.max' => 'O campo "Profissão" não pode ter mais de 255 caracteres.',
            'companies.array' => 'O campo "Organizações" deve ser uma lista válida.',
            'companies.*.exists' => 'Uma ou mais empresas selecionadas são inválidas.',
            'job_position.max' => 'O campo "Cargo" não pode ter mais de 255 caracteres.',
            'schollarity.max' => 'O campo "Escolaridade" não pode ter mais de 255 caracteres.',
            'usp_id.max' => 'O campo "Número USP" não pode ter mais de 8 caracteres.',
            'area_of_knowledge_1.max' => 'O campo "Área do Conhecimento 1" não pode ter mais de 255 caracteres.',
            'area_of_knowledge_2.max' => 'O campo "Área do Conhecimento 2" não pode ter mais de 255 caracteres.',
            'area_of_knowledge_3.max' => 'O campo "Área do Conhecimento 3" não pode ter mais de 255 caracteres.',
            'area_of_knowledge_4.max' => 'O campo "Área do Conhecimento 4" não pode ter mais de 255 caracteres.',
            'area_of_knowledge_5.max' => 'O campo "Área do Conhecimento 5" não pode ter mais de 255 caracteres.',
            'email.email' => 'O campo "Email" deve ser um endereço de email válido.',
            'email.max' => 'O campo "Email" não pode ter mais de 255 caracteres.',
            'phone.max' => 'O campo "Telefone" não pode ter mais de 20 caracteres.',
            'site.url' => 'O campo "Site" deve ser uma URL válida.',
            'site.max' => 'O campo "Site" não pode ter mais de 255 caracteres.',
            'instagram.max' => 'O campo "Instagram" não pode ter mais de 255 caracteres.',
            'facebook.max' => 'O campo "Facebook" não pode ter mais de 255 caracteres.',
            'linkedin.max' => 'O campo "LinkedIn" não pode ter mais de 255 caracteres.',
            'twitter.max' => 'O campo "Twitter" não pode ter mais de 255 caracteres.',
            'address.max' => 'O campo "Endereço" não pode ter mais de 255 caracteres.',
            'city.max' => 'O campo "Cidade" não pode ter mais de 255 caracteres.',
            'neighborhood.max' => 'O campo "Bairro" não pode ter mais de 255 caracteres.',
            'state.max' => 'O campo "Estado" não pode ter mais de 255 caracteres.',
            'country.max' => 'O campo "País" não pode ter mais de 255 caracteres.',
            'zip_code.max' => 'O campo "CEP" não pode ter mais de 20 caracteres.',
            'civil_state.max' => 'O campo "Estado Civil" não pode ter mais de 255 caracteres.',
            'naturality.max' => 'O campo "Naturalidade" não pode ter mais de 255 caracteres.',
            'kids.integer' => 'O campo "Número de Filhos" deve ser um número inteiro.',
            'kids.min' => 'O campo "Número de Filhos" não pode ser negativo.',
            'hobbie.max' => 'O campo "Hobbie" não pode ter mais de 255 caracteres.',
            'income.max' => 'O campo "Renda" não pode ter mais de 255 caracteres.',
            'religion.max' => 'O campo "Religião" não pode ter mais de 255 caracteres.',
            'etinicity.max' => 'O campo "Etnia" não pode ter mais de 255 caracteres.',
            'gender.max' => 'O campo "Gênero" não pode ter mais de 255 caracteres.',
            'type.max' => 'O campo "Tipo" não pode ter mais de 255 caracteres.',
            'observation.string' => 'O campo "Observação" deve ser um texto válido.',
            'status.in' => 'O campo "Status" deve ser um dos valores: ativo, pendente ou desativado.',
        ];
    }
}

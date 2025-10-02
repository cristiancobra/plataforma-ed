<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Valida o arquivo de imagem
            'name' => 'required|string|max:255',
            'alt' => 'nullable|string',
            'type' => 'required|string|in:produto,logo,imagem perfil,marketing', // Tipos válidos
            'status' => 'required|string|in:disponível,indisponível', // Status válidos
            'user_id' => 'required|exists:users,id', // Certifica-se de que o usuário existe
        ];
    }

    /**
     * Mensagens de erro personalizadas (opcional).
     */
    public function messages()
    {
        return [
            'image.image' => 'O arquivo enviado deve ser uma imagem.',
            'image.mimes' => 'A imagem deve estar no formato: jpeg, png, jpg ou gif.',
            'image.max' => 'A imagem não pode ter mais de 2MB.',
            'name.required' => 'O campo Nome é obrigatório.',
            'type.in' => 'O tipo selecionado é inválido.',
            'status.in' => 'O status selecionado é inválido.',
            'user_id.exists' => 'O usuário selecionado não existe.',
        ];
    }
}
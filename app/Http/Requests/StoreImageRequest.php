<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:50000',
            'task_id' => 'nullable|exists:tasks,id',
            'text_id' => 'nullable|exists:texts,id',
            'image_name' => 'nullable|string|max:255',
        ];
    }
    
    public function messages()
    {
        return [
            'image.required' => 'Por favor, selecione uma imagem.',
            'image.image' => 'O arquivo deve ser uma imagem válida.',
            'image.mimes' => 'A imagem deve ser: jpeg, png, jpg, gif, svg ou webp.',
            'image.max' => 'O tamanho máximo permitido é 50MB.',
            'task_id.exists' => 'Tarefa não encontrada.',
            'text_id.exists' => 'Texto não encontrado.',
        ];
    }
}
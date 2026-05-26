<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollectionRequest extends FormRequest
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
            'type_id' => 'required|exists:collection_types,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'patrimony_number' => 'nullable|string|max:100',
            'control_code' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'purchase_date' => 'nullable|date',
            'manufacturing_date' => 'nullable|date',
            'operating_system' => 'nullable|string|max:100',
            'video_card' => 'nullable|string|max:100',
            'best_ai' => 'nullable|string|max:100',
            'password' => 'nullable|string|max:255',
            'users' => 'nullable|string|max:255',
            'runs_adobe' => 'nullable|string|max:50',
            'runs_vrchat' => 'nullable|string|max:50',
            'video_url' => 'nullable|url|max:500',
            'code_url' => 'nullable|url|max:500',
            'image_url' => 'nullable|url|max:500',
            'status' => 'nullable|string|max:50',
            'tracking_tag' => 'nullable|string|max:255',
            'redirect_link' => 'nullable|string|max:500',
            'serial_number' => 'nullable|string|max:255',
            'accessories' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'type_id.required' => 'O tipo é obrigatório.',
            'type_id.exists' => 'O tipo selecionado é inválido.',
            'purchase_date.date' => 'Data de compra inválida.',
            'manufacturing_date.date' => 'Data de fabricação inválida.',
            'video_url.url' => 'URL do vídeo inválida.',
            'code_url.url' => 'URL do código inválida.',
            'image_url.url' => 'URL da imagem inválida.',
        ];
    }
}

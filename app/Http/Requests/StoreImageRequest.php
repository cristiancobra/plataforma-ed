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
            'name' => 'required',
            'alt' => 'required',
            'image' => 'required|image|max:50000',
            'status' => 'required',
            'type' => 'required',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => ' *obrigatório.',
            'alt.required' => ' *obrigatório.',
            'image.required' => ' *obrigatório.',
            'image.image' => ' *o arquivo deve ser uma imagem.',
            'image.max' => ' *o tamanho máximo permitido é 50MB.',
        ];
    }
}
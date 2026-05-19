<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCollectionTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $id = $this->route('collectionType')->id ?? null;
        return [
            'name' => 'required|string|max:255|unique:collection_types,name,' . $id . ',id,account_id,' . Auth::user()->account_id,
            'category' => 'required|string|in:físico,digital',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.unique' => 'Já existe um tipo com esse nome para sua conta.',
        ];
    }
}

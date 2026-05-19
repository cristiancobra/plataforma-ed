<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCollectionTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:collection_types,name,NULL,id,account_id,' . Auth::user()->account_id,
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

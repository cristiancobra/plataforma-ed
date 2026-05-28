<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCollectionsGroupRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $id = $this->route('collections_group')->id ?? null;
        return [
            'name' => 'required|string|max:255|unique:collections_group,name,' . $id . ',id,account_id,' . Auth::user()->account_id,
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.unique' => 'Já existe um grupo com esse nome para sua conta.',
        ];
    }
}

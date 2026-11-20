<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidatesCollectionTypeFields;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCollectionTypeRequest extends FormRequest
{
    use ValidatesCollectionTypeFields;

    protected function prepareForValidation()
    {
        $this->prepareFieldsForValidation();
    }

    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:collection_types,name,NULL,id,account_id,' . Auth::user()->account_id,
            'category' => 'required|string|in:físico,digital',
        ] + $this->fieldRules();
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.unique' => 'Já existe um tipo com esse nome para sua conta.',
        ] + $this->fieldMessages();
    }
}

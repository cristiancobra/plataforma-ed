<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'attachment' => 'required|file|mimes:pdf|max:10240', // 10MB max
            'task_id' => 'nullable|exists:tasks,id',
            'text_id' => 'nullable|exists:texts,id',
            'attachment_name' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'attachment.required' => 'Por favor, selecione um arquivo PDF.',
            'attachment.file' => 'O arquivo enviado é inválido.',
            'attachment.mimes' => 'Apenas arquivos PDF são permitidos.',
            'attachment.max' => 'O arquivo não pode ser maior que 10MB.',
            'task_id.exists' => 'Tarefa não encontrada.',
            'text_id.exists' => 'Texto não encontrado.',
        ];
    }
}
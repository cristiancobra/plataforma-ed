<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'description' => 'nullable|string',
            'department' => 'required|string|in:administrativo,atendimento,desenvolvimento,financeiro,marketing,produção,vendas,tarefa pessoal',
            'priority' => 'required|string|in:baixa,média,alta,emergência',
            'status' => 'nullable|string|in:fazer,aguardar,feito,fazendo,cancelado',
            'type' => 'nullable|string',
            'date_start' => 'nullable|date',
            'date_due' => 'nullable|date|after_or_equal:date_start',
            'date_conclusion' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'duration' => 'nullable|integer|min:0',
            'points' => 'nullable|integer|min:0',
            'user_id' => 'nullable|exists:users,id',
            'company_id' => 'nullable|exists:companies,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'project_id' => 'nullable|exists:projects,id',
            'opportunity_id' => 'nullable|exists:opportunities,id',
            'stage_id' => 'nullable|exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attachment' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da tarefa é obrigatório.',
            'name.max' => 'O nome da tarefa não pode ter mais de 255 caracteres.',
            'department.required' => 'O departamento é obrigatório.',
            'department.in' => 'O departamento selecionado é inválido.',
            'priority.required' => 'A prioridade é obrigatória.',
            'priority.in' => 'A prioridade selecionada é inválida.',
            'status.in' => 'O status selecionado é inválido.',
            'date_due.after_or_equal' => 'A data de vencimento deve ser posterior à data de início.',
            'end_time.after' => 'O horário final deve ser posterior ao horário inicial.',
            'image.image' => 'O arquivo deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif.',
            'image.max' => 'A imagem não pode ser maior que 2MB.',
            'attachment.file' => 'O arquivo enviado é inválido.',
            'attachment.mimes' => 'Apenas arquivos PDF são permitidos.',
            'attachment.max' => 'O arquivo não pode ser maior que 10MB.',
        ];
    }
}

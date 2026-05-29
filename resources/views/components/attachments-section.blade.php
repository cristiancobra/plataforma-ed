@php
    $typeLabels = [
        'nota_fiscal' => 'Nota fiscal',
        'termo_emprestimo' => 'Termo de empréstimo',
        'termo_referencia' => 'Termo de referência',
        'orcamento_aprovado' => 'Orçamento aprovado',
        'orcamento_concorrente' => 'Orçamento concorrente',
        'boleto' => 'Boleto',
        // Adicione outros tipos conforme necessário
    ];
@endphp
@props([
    'title' => 'ANEXOS',
    'attachments' => collect([]),
    'modelIdField',
    'modelId',
    'types' => [], // pode ser array de strings (values) ou array associativo
    'principalColor' => '#007bff',
])

<div class="row g-0 mb-2 mt-5">
    <h4 class="fw-bold" style="color: {{ $principalColor }}">
        {{ $title }}
    </h4>
</div>
<div class="border rounded p-3 bg-light mb-3">
    @if ($attachments && $attachments->count())
        <div class="row mt-3">
            @foreach ($attachments as $attachment)
                <div class='col-md-3 mb-4'>
                    <div class="card text-center p-3 h-100 shadow-sm" style="border: 2px solid #e0e0e0;">
                        <i class="fa fa-file-invoice-dollar" style="font-size: 60px; color:{{ $principalColor }}"></i>
                        <div class="mt-2">
                            <span class="badge bg-secondary text-white" style="font-size: 11px;">
                                {{ $typeLabels[$attachment->type] ?? ucfirst(str_replace('_', ' ', $attachment->type)) }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <strong style="font-size: 13px;">{{ Str::limit($attachment->name, 30) }}</strong>
                        </div>
                        <small class="text-muted mt-2">{{ date('d/m/Y', strtotime($attachment->created_at)) }}</small>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <form action="{{ route('attachment.destroy', ['attachment' => $attachment->id]) }}"
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir este documento?');"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                    <i class="fa fa-trash"></i> Excluir
                                </button>
                            </form>
                            <a href="{{ asset('storage/' . $attachment->path) }}" download="{{ $attachment->name }}"
                                class="btn btn-sm" title="Baixar"
                                style="background-color: {{ $principalColor }}; color: white;">
                                <i class="fa fa-download"></i> Baixar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted mb-3">Nenhum documento anexado ainda.</p>
    @endif


    <form action="{{ route('attachment.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="{{ $modelIdField }}" value="{{ $modelId }}">
        <div class='row mt-3'>
            <div class='col-md-4'>
                <label class='labels mb-2' for='attachment_type'>Tipo de documento:</label>
                <select id='attachment_type' name='type' class='form-control' required>
                    <option value=''>Selecione o tipo</option>
                    @foreach ($types as $type)
                        @php
                            $value = is_array($type) ? $type['value'] : $type;
                        @endphp
                        <option value="{{ $value }}">
                            {{ $typeLabels[$value] ?? ucfirst(str_replace('_', ' ', $value)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class='col-md-4'>
                <label class='labels mb-2' for='attachment_file'>Selecione o arquivo PDF:</label>
                <input type='file' id='attachment_file' name='attachment' accept=".pdf" class='form-control'
                    required>
            </div>
            <div class='col-md-4'>
                <button type="submit" class='btn w-100'
                    style="margin-top: 32px; background-color: {{ $principalColor }}; color: white;">
                    <i class="fa fa-upload me-2"></i> Enviar Documento
                </button>
            </div>
        </div>
    </form>
</div>

@extends('layouts/show')

@section('title', 'ORGANIZAÇÕES')

@php
    // etiqueta (pill) como HtmlString, para usar dentro de <x-show.field-grid>
    $badge = fn ($label, $colors = null) => new \Illuminate\Support\HtmlString(
        \Illuminate\Support\Facades\Blade::render('<x-table.badge :label="$label" :colors="$colors" />', compact('label', 'colors'))
    );
    $link = fn ($url, $text = null) => $url
        ? new \Illuminate\Support\HtmlString('<a href="' . e(preg_match('#^https?://#i', $url) ? $url : 'https://' . $url) . '" target="_blank" rel="noopener">' . e($text ?? $url) . '</a>')
        : null;
    $mailto = fn ($email) => $email
        ? new \Illuminate\Support\HtmlString('<a href="mailto:' . e($email) . '">' . e($email) . '</a>')
        : null;
    $cadin = fn ($value) => $badge(\App\Models\Company::cadinLabel($value) ?? 'Não consultado', \App\Models\Company::cadinColors($value));
    $sectionTitle = fn ($title) => new \Illuminate\Support\HtmlString(
        '<h4 class="mb-3 fw-bold" style="color: ' . e($principalColor) . '">' . e($title) . '</h4>'
    );
    $grid = fn ($items) => array_values(array_filter($items, fn ($item) => $item['value'] !== null && $item['value'] !== ''));
@endphp

@section('image-top')
    <i class="fa fa-building"></i>
@endsection

@section('buttons')
    <x-buttons.edit model="company" :object="$company" parameter2="typeCompanies" :value2="$company->type" :principalColor="$principalColor" />
    <x-buttons.list model="company" parameter="typeCompanies" :value="$company->type" :principalColor="$principalColor" />
@endsection

@section('trash')
    <form class="d-inline-block" action="{{ route('company.destroy', $company) }}" method="post"
        onsubmit="return confirm('Tem certeza que deseja apagar esta organização? Esta ação não pode ser desfeita.')">
        @csrf
        @method('DELETE')
        <button class="btn rounded-circle" title="Apagar organização" type="submit"
            style="background-color: #dc3545; border-color: #dc3545; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endsection

@section('name', $company->name)

@section('fieldsId')
    <x-show.field-grid :items="[
        ['label' => 'TIPO', 'value' => $company->type],
        ['label' => 'SITUAÇÃO', 'value' => $badge($company->status, \App\Models\Company::statusColors($company->status))],
        ['label' => 'CNPJ', 'value' => $company->cnpj],
        ['label' => 'CONSULTA CADIN', 'value' => $company->cadin_checked_at?->format('d/m/Y')],
        ['label' => 'CADIN ESTADUAL', 'value' => $cadin($company->cadin_estadual)],
        ['label' => 'CADIN FEDERAL', 'value' => $cadin($company->cadin_federal)],
    ]" />
@endsection

@section('description')
    {{ $company->description ?: 'Sem descrição.' }}
@endsection

@section('main')
    <div class="row mt-5">
        {{ $sectionTitle('CONTATO') }}
        <x-show.field-grid :items="[
            ['label' => 'EMAIL', 'value' => $mailto($company->email)],
            ['label' => 'EMAIL FINANCEIRO', 'value' => $mailto($company->financial_email)],
            ['label' => 'TELEFONE', 'value' => $company->phone],
            ['label' => 'SITE', 'value' => $link($company->site)],
        ]" />
    </div>

    <div class="row mt-5">
        {{ $sectionTitle('LOCALIZAÇÃO') }}
        <x-show.field-grid :items="[
            ['label' => 'ENDEREÇO', 'value' => $company->address],
            ['label' => 'BAIRRO', 'value' => $company->neighborhood],
            ['label' => 'CEP', 'value' => $company->zip_code],
            ['label' => 'CIDADE', 'value' => $company->city],
            ['label' => 'ESTADO', 'value' => $company->state ? returnStateName($company->state) : null],
            ['label' => 'PAÍS', 'value' => $company->country],
        ]" />
    </div>

    @php
        $activities = $grid(array_map(fn ($i) => ['label' => "ÁREA $i", 'value' => $company->{"field_of_activity_$i"}], range(1, 5)));
        $profile = $grid([
            ['label' => 'EMPREGADOS', 'value' => $company->employees],
            ['label' => 'CLIENTES', 'value' => $company->client_number],
            ['label' => 'FATURAMENTO', 'value' => $company->revenues ? formatCurrencyReal($company->revenues) : null],
            ['label' => 'SETOR', 'value' => \App\Models\Company::SECTORS[$company->sector] ?? $company->sector],
            ['label' => 'MODELO DE NEGÓCIOS', 'value' => \App\Models\Company::businessModelTypes()[$company->business_model] ?? $company->business_model],
            ['label' => 'DIFERENCIAL COMPETITIVO', 'value' => $company->competitive_advantage],
        ]);
        $valueOffer = trim(strip_tags(html_entity_decode((string) $company->value_offer)));
    @endphp

    @if ($activities)
        <div class="row mt-5">
            {{ $sectionTitle('ÁREAS DE ATUAÇÃO') }}
            <x-show.field-grid :items="$activities" />
        </div>
    @endif

    @if ($profile || $valueOffer)
        <div class="row mt-5">
            {{ $sectionTitle('PERFIL') }}
            @if ($profile)
                <x-show.field-grid :items="$profile" />
            @endif
            @if ($valueOffer)
                <div class="fw-bold small mt-2 mb-1" style="color: {{ $principalColor }}">PROPOSTA DE VALOR</div>
                <div class="border rounded p-3 bg-light">{!! nl2br(e($valueOffer)) !!}</div>
            @endif
        </div>
    @endif

    <div class="row mt-5">
        {{ $sectionTitle('REDES SOCIAIS') }}
        <x-show.field-grid :items="[
            ['label' => 'INSTAGRAM', 'value' => $company->instagram],
            ['label' => 'FACEBOOK', 'value' => $company->facebook],
            ['label' => 'LINKEDIN', 'value' => $company->linkedin],
            ['label' => 'TWITTER', 'value' => $company->twitter],
        ]" />
        @foreach ($company->socialmedias as $socialmedia)
            <div class="row border-bottom align-items-center py-2 mx-0">
                <div class="col-10">
                    <span class="fw-bold">{{ $socialmedia->name }}</span>
                    <span class="text-muted">— {{ $socialmedia->socialmedia_name }}</span>
                </div>
                <div class="col-2 text-end">
                    <x-buttons.details :href="route('socialmedia.show', ['socialmedia' => $socialmedia->id])" :color="$principalColor" :size="32" />
                </div>
            </div>
        @endforeach
        <div class="mt-3">
            <a class="btn text-white" style="background-color: {{ $principalColor }};" target="_blank"
                href="{{ route('socialmedia.create', ['company_id' => $company->id, 'type' => $company->type]) }}">
                <i class="fa fa-plus me-1"></i> Nova rede social
            </a>
        </div>
    </div>

    <div class="row mt-5">
        {{ $sectionTitle('EQUIPE') }}
        @forelse ($company->contacts as $contact)
            <div class="row border-bottom align-items-center py-2 mx-0">
                <div class="col-10">
                    <span class="fw-bold">{{ $contact->name }}</span>
                    @if ($contact->job_position)
                        <span class="text-muted">— {{ $contact->job_position }}</span>
                    @endif
                </div>
                <div class="col-2 text-end">
                    <x-buttons.details :href="route('contact.show', ['contact' => $contact->id])" :color="$principalColor" :size="32" />
                </div>
            </div>
        @empty
            <p class="text-muted">Nenhum contato vinculado.</p>
        @endforelse
    </div>
@endsection

@section('createdAt')
    <p class="text-muted small text-end me-4">
        Criado em {{ $company->created_at?->format('d/m/Y H:i') }}
        @if ($company->updated_at && $company->updated_at != $company->created_at)
            · atualizado em {{ $company->updated_at->format('d/m/Y H:i') }}
        @endif
    </p>
@endsection

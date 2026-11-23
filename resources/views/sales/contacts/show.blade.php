@extends('layouts/show')

@section('title', 'CONTATOS')

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
    $yesNo = fn ($value) => $value
        ? $badge('sim', ['#E8F5E9', '#2E7D32'])
        : $badge('não', ['#ECEFF1', '#546E7A']);
    $sectionTitle = fn ($title) => new \Illuminate\Support\HtmlString(
        '<h4 class="mb-3 fw-bold" style="color: ' . e($principalColor) . '">' . e($title) . '</h4>'
    );
    $grid = fn ($items) => array_values(array_filter($items, fn ($item) => $item['value'] !== null && $item['value'] !== ''));
@endphp

@section('image-top')
    <i class="fas fa-address-book"></i>
@endsection

@section('buttons')
    <x-buttons.edit model="contact" :object="$contact" :principalColor="$principalColor" />
    <x-buttons.list model="contact" :principalColor="$principalColor" />
@endsection

@section('trash')
    <form class="d-inline-block" action="{{ route('contact.destroy', $contact) }}" method="post"
        onsubmit="return confirm('Tem certeza que deseja apagar este contato? Esta ação não pode ser desfeita.')">
        @csrf
        @method('DELETE')
        <button class="btn rounded-circle" title="Apagar contato" type="submit"
            style="background-color: #dc3545; border-color: #dc3545; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endsection

@section('name', $contact->name)

@section('fieldsId')
    <x-show.field-grid :items="[
        ['label' => 'TIPO', 'value' => $contact->type],
        ['label' => 'SITUAÇÃO', 'value' => $badge($contact->status, \App\Models\Contact::statusColors($contact->status))],
        ['label' => 'ORIGEM', 'value' => $contact->lead_source],
        ['label' => 'PONTOS', 'value' => $contact->points],
        ['label' => 'EMAIL', 'value' => $mailto($contact->email)],
        ['label' => 'TELEFONE', 'value' => $contact->phone],
    ]" />
@endsection

@section('description')
    @if ($contact->observations)
        {!! nl2br(e($contact->observations)) !!}
    @else
        <span class="text-muted">Sem observações.</span>
    @endif
@endsection

@section('main')
    @php
        $areas = collect(range(1, 5))->map(fn ($i) => $contact->{"area_of_knowledge_$i"})->filter()->implode(', ');
        $professional = $grid([
            ['label' => 'PROFISSÃO', 'value' => $contact->profession],
            ['label' => 'CARGO', 'value' => $contact->job_position],
            ['label' => 'ESCOLARIDADE', 'value' => \App\Models\Contact::SCHOLLARITIES[$contact->schollarity] ?? $contact->schollarity],
            ['label' => 'NÚMERO USP', 'value' => $contact->usp_id],
            ['label' => 'ÁREAS DO CONHECIMENTO', 'value' => $areas],
        ]);
        $social = $grid([
            ['label' => 'SITE', 'value' => $link($contact->site)],
            ['label' => 'INSTAGRAM', 'value' => $contact->instagram],
            ['label' => 'FACEBOOK', 'value' => $contact->facebook],
            ['label' => 'LINKEDIN', 'value' => $contact->linkedin],
            ['label' => 'TWITTER', 'value' => $contact->twitter],
        ]);
        $location = $grid([
            ['label' => 'ENDEREÇO', 'value' => $contact->address],
            ['label' => 'BAIRRO', 'value' => $contact->neighborhood],
            ['label' => 'CEP', 'value' => $contact->zip_code],
            ['label' => 'CIDADE', 'value' => $contact->city],
            ['label' => 'ESTADO', 'value' => $contact->state ? returnStateName($contact->state) : null],
            ['label' => 'PAÍS', 'value' => $contact->country],
        ]);
        $profile = $grid([
            ['label' => 'NASCIMENTO', 'value' => $contact->date_birth ? date('d/m/Y', strtotime($contact->date_birth)) : null],
            ['label' => 'CPF', 'value' => $contact->cpf],
            ['label' => 'GÊNERO', 'value' => $contact->gender],
            ['label' => 'ESTADO CIVIL', 'value' => \App\Models\Contact::CIVIL_STATES[$contact->civil_state] ?? $contact->civil_state],
            ['label' => 'NATURALIDADE', 'value' => $contact->naturality],
            ['label' => 'FILHOS', 'value' => $contact->kids],
            ['label' => 'HOBBIE', 'value' => $contact->hobbie],
            ['label' => 'RENDA', 'value' => $contact->income],
            ['label' => 'RELIGIÃO', 'value' => $contact->religion],
            ['label' => 'ETNIA', 'value' => $contact->etinicity],
        ]);
    @endphp

    @if ($professional)
        <div class="row mt-5">
            {{ $sectionTitle('PROFISSIONAL') }}
            <x-show.field-grid :items="$professional" />
        </div>
    @endif

    @if ($social)
        <div class="row mt-5">
            {{ $sectionTitle('SITE E REDES SOCIAIS') }}
            <x-show.field-grid :items="$social" />
        </div>
    @endif

    @if ($location)
        <div class="row mt-5">
            {{ $sectionTitle('LOCALIZAÇÃO') }}
            <x-show.field-grid :items="$location" />
        </div>
    @endif

    @if ($profile)
        <div class="row mt-5">
            {{ $sectionTitle('PERFIL') }}
            <x-show.field-grid :items="$profile" />
        </div>
    @endif

    <div class="row mt-5">
        {{ $sectionTitle('AUTORIZAÇÕES') }}
        <x-show.field-grid :items="[
            ['label' => 'DADOS PESSOAIS', 'value' => $yesNo($contact->authorization_data)],
            ['label' => 'CONTATO', 'value' => $yesNo($contact->authorization_contact)],
            ['label' => 'NEWSLETTER', 'value' => $yesNo($contact->authorization_newsletter)],
        ]" />
    </div>

    <div class="row mt-5">
        {{ $sectionTitle('ORGANIZAÇÕES') }}
        @forelse ($contact->companies as $company)
            <div class="row border-bottom align-items-center py-2 mx-0">
                <div class="col-10">
                    <span class="fw-bold">{{ $company->name }}</span>
                    @if ($company->type)
                        <span class="text-muted">— {{ $company->type }}</span>
                    @endif
                </div>
                <div class="col-2 text-end">
                    <x-buttons.details :href="route('company.show', ['company' => $company, 'typeCompanies' => $company->type])"
                        :color="$principalColor" :size="32" />
                </div>
            </div>
        @empty
            <p class="text-muted">Nenhuma organização vinculada.</p>
        @endforelse
    </div>

    <div class="row mt-5">
        {{ $sectionTitle('OPORTUNIDADES') }}
        @forelse ($contact->opportunities as $opportunity)
            <div class="row border-bottom align-items-center py-2 mx-0">
                <div class="col-8 fw-bold">{{ $opportunity->name }}</div>
                <div class="col-2 text-center">
                    <x-table.badge :label="$opportunity->status" />
                </div>
                <div class="col-2 text-end">
                    <x-buttons.details :href="route('opportunity.show', $opportunity)" :color="$principalColor" :size="32" />
                </div>
            </div>
        @empty
            <p class="text-muted">Nenhuma oportunidade cadastrada.</p>
        @endforelse
    </div>

    @if ($contact->images->isNotEmpty())
        <div class="row mt-5">
            {{ $sectionTitle('IMAGENS ENVIADAS') }}
            @foreach ($contact->images as $image)
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('image.show', $image) }}" class="d-block text-decoration-none">
                        <img src="{{ asset($image->path) }}" class="img-thumbnail w-100" style="height: 140px; object-fit: cover;"
                            alt="{{ $image->name }}">
                        <div class="small text-muted mt-1 text-truncate">{{ $image->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@section('createdAt')
    <p class="text-muted small text-end me-4">
        Criado em {{ $contact->created_at?->format('d/m/Y H:i') }}
        @if ($contact->updated_at && $contact->updated_at != $contact->created_at)
            · atualizado em {{ $contact->updated_at->format('d/m/Y H:i') }}
        @endif
    </p>
@endsection

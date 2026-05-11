@extends('layouts/show')

@section('title', 'CONTATOS')

@section('image-top')
    <i class="fas fa-address-book"></i>
@endsection


@section('buttons')
    <x-buttons.edit model="contact" :object="$contact" :principalColor="$principalColor" />
    {{ createButtonList('contact') }}
@endsection

@section('name', $contact->name)


@section('priority')
    <div class="high pe-2 d-flex justify-content-end">{{ $contact->points }} pontos</div>
@endsection


@section('status')
    {{ formatShowStatus($contact) }}
@endsection

@section('fieldsId')
    <div class='col-md-2 col-sm-4' style='text-align: center'>
        <div class='show-label'>
            ORIGEM
        </div>

    </div>
    <div class='col-md-4 col-sm-8' style='text-align: center'>
        @if (isset($contact->lead_source))
            <a href='{{ route('contact.show', ['contact' => $contact]) }}'>
                <div class='show-field-end'>
                    {{ $contact->lead_source }}
                </div>
            </a>
        @else
            <div class='show-field-end'>
                --
            </div>
        @endif
    </div>

    <div class='col-md-2 col-sm-4' style='text-align: center'>
        <div class='show-label'>
            ADICIONADO EM
        </div>
    </div>
    <div class='col-md-4 col-sm-8' style='text-align: center'>
        <div class='show-field-end d-flex justify-content-end'>
            {{ date('d/m/Y H:i', strtotime($contact->created_at)) }}
        </div>
    </div>
@endsection

@section('description')
    @if ($contact->observations)
        <div class="d-flex align-items-start">
            <i class="fas fa-comment-dots me-2 mt-1" style="color: {{ $principalColor }}"></i>
            <span>{{ $contact->observations }}</span>
        </div>
    @else
        <span class="text-muted"><i class="fas fa-info-circle me-1"></i>Sem observações</span>
    @endif
@endsection

@section('main')
    <style>
        .info-label {
            font-weight: 600;
            color: #6c757d;
            margin-right: 8px;
        }

        .info-value {
            color: #333;
        }

        .info-row {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }
    </style>

    <div class="row mt-4">
        <div class="col-lg-6">
            <!-- SEÇÃO PESSOAL -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i class="fas fa-user me-2"></i>PESSOAL</h5>
                </div>
                <div class="card-body">
                    @if ($contact->first_name)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-user-tag me-1"></i>Primeiro nome:</span>
                            <span class="info-value">{{ $contact->first_name }}</span>
                        </div>
                    @endif
                    @if ($contact->last_name)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-user-tag me-1"></i>Sobrenome:</span>
                            <span class="info-value">{{ $contact->last_name }}</span>
                        </div>
                    @endif
                    @if ($contact->date_birth)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-birthday-cake me-1"></i>Data de nascimento:</span>
                            <span class="info-value">{{ date('d/m/Y', strtotime($contact->date_birth)) }}</span>
                        </div>
                    @endif
                    @if ($contact->cpf)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-id-card me-1"></i>CPF:</span>
                            <span class="info-value">{{ $contact->cpf }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEÇÃO PROFISSIONAL -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i class="fas fa-briefcase me-2"></i>PROFISSIONAL
                    </h5>
                </div>
                <div class="card-body">
                    @if ($contact->profession)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-user-tie me-1"></i>Profissão:</span>
                            <span class="info-value">{{ $contact->profession }}</span>
                        </div>
                    @endif
                    @if ($contact->job_position)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-briefcase me-1"></i>Cargo:</span>
                            <span class="info-value">{{ $contact->job_position }}</span>
                        </div>
                    @endif
                    @if ($contact->schollarity)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-graduation-cap me-1"></i>Escolaridade:</span>
                            <span class="info-value">{{ $contact->schollarity }}</span>
                        </div>
                    @endif
                    @if ($contact->usp_id)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-university me-1"></i>Número USP:</span>
                            <span class="info-value">{{ $contact->usp_id }}</span>
                        </div>
                    @endif
                    @if (
                        $contact->area_of_knowledge_1 ||
                            $contact->area_of_knowledge_2 ||
                            $contact->area_of_knowledge_3 ||
                            $contact->area_of_knowledge_4 ||
                            $contact->area_of_knowledge_5)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-book me-1"></i>Áreas do conhecimento:</span>
                            <div class="mt-2">
                                @if ($contact->area_of_knowledge_1)
                                    <span class="badge"
                                        style="background-color: {{ $complementaryColor }}">{{ $contact->area_of_knowledge_1 }}</span>
                                @endif
                                @if ($contact->area_of_knowledge_2)
                                    <span class="badge"
                                        style="background-color: {{ $complementaryColor }}">{{ $contact->area_of_knowledge_2 }}</span>
                                @endif
                                @if ($contact->area_of_knowledge_3)
                                    <span class="badge"
                                        style="background-color: {{ $complementaryColor }}">{{ $contact->area_of_knowledge_3 }}</span>
                                @endif
                                @if ($contact->area_of_knowledge_4)
                                    <span class="badge"
                                        style="background-color: {{ $complementaryColor }}">{{ $contact->area_of_knowledge_4 }}</span>
                                @endif
                                @if ($contact->area_of_knowledge_5)
                                    <span class="badge"
                                        style="background-color: {{ $complementaryColor }}">{{ $contact->area_of_knowledge_5 }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEÇÃO CONTATOS -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i class="fas fa-envelope me-2"></i>CONTATOS</h5>
                </div>
                <div class="card-body">
                    @if ($contact->email)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-envelope me-1"></i>Email:</span>
                            <a href="mailto:{{ $contact->email }}"
                                style="color: {{ $principalColor }}">{{ $contact->email }}</a>
                        </div>
                    @endif
                    @if ($contact->phone)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-phone me-1"></i>Telefone:</span>
                            <span class="info-value">{{ $contact->phone }}</span>
                        </div>
                    @endif
                    @if ($contact->site)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-globe me-1"></i>Site:</span>
                            <a href="{{ $contact->site }}" target="_blank"
                                style="color: {{ $principalColor }}">{{ $contact->site }}</a>
                        </div>
                    @endif
                    @if ($contact->instagram)
                        <div class="info-row">
                            <span class="info-label"><i class="fab fa-instagram me-1"></i>Instagram:</span>
                            <span class="info-value">{{ $contact->instagram }}</span>
                        </div>
                    @endif
                    @if ($contact->facebook)
                        <div class="info-row">
                            <span class="info-label"><i class="fab fa-facebook me-1"></i>Facebook:</span>
                            <span class="info-value">{{ $contact->facebook }}</span>
                        </div>
                    @endif
                    @if ($contact->linkedin)
                        <div class="info-row">
                            <span class="info-label"><i class="fab fa-linkedin me-1"></i>LinkedIn:</span>
                            <span class="info-value">{{ $contact->linkedin }}</span>
                        </div>
                    @endif
                    @if ($contact->twitter)
                        <div class="info-row">
                            <span class="info-label"><i class="fab fa-twitter me-1"></i>Twitter:</span>
                            <span class="info-value">{{ $contact->twitter }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEÇÃO LOCALIZAÇÃO -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i
                            class="fas fa-map-marker-alt me-2"></i>LOCALIZAÇÃO</h5>
                </div>
                <div class="card-body">
                    @if ($contact->address)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-home me-1"></i>Endereço:</span>
                            <span class="info-value">{{ $contact->address }}</span>
                        </div>
                    @endif
                    @if ($contact->neighborhood)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-map me-1"></i>Bairro:</span>
                            <span class="info-value">{{ $contact->neighborhood }}</span>
                        </div>
                    @endif
                    @if ($contact->city)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-city me-1"></i>Cidade:</span>
                            <span class="info-value">{{ $contact->city }}</span>
                        </div>
                    @endif
                    @if ($contact->state)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-map-marked-alt me-1"></i>Estado:</span>
                            <span class="info-value">{{ $contact->state }}</span>
                        </div>
                    @endif
                    @if ($contact->country)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-flag me-1"></i>País:</span>
                            <span class="info-value">{{ $contact->country }}</span>
                        </div>
                    @endif
                    @if ($contact->zip_code)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-mail-bulk me-1"></i>CEP:</span>
                            <span class="info-value">{{ $contact->zip_code }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEÇÃO PERFIL -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i class="fas fa-user-circle me-2"></i>PERFIL
                    </h5>
                </div>
                <div class="card-body">
                    @if ($contact->civil_state)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-heart me-1"></i>Estado civil:</span>
                            <span class="info-value">{{ $contact->civil_state }}</span>
                        </div>
                    @endif
                    @if ($contact->naturality)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-map-pin me-1"></i>Naturalidade:</span>
                            <span class="info-value">{{ $contact->naturality }}</span>
                        </div>
                    @endif
                    @if ($contact->kids !== null)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-baby me-1"></i>Filhos:</span>
                            <span class="info-value">{{ $contact->kids }}</span>
                        </div>
                    @endif
                    @if ($contact->hobbie)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-gamepad me-1"></i>Hobbie:</span>
                            <span class="info-value">{{ $contact->hobbie }}</span>
                        </div>
                    @endif
                    @if ($contact->income)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-dollar-sign me-1"></i>Renda:</span>
                            <span class="info-value">{{ $contact->income }}</span>
                        </div>
                    @endif
                    @if ($contact->religion)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-praying-hands me-1"></i>Religião:</span>
                            <span class="info-value">{{ $contact->religion }}</span>
                        </div>
                    @endif
                    @if ($contact->etinicity)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-users me-1"></i>Etnia:</span>
                            <span class="info-value">{{ $contact->etinicity }}</span>
                        </div>
                    @endif
                    @if ($contact->gender)
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-venus-mars me-1"></i>Gênero:</span>
                            <span class="info-value">{{ $contact->gender }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- AUTORIZAÇÕES -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i
                            class="fas fa-shield-alt me-2"></i>AUTORIZAÇÕES</h5>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="form-check">
                            {{ createCheckboxReadOnly('authorization_data', $contact->authorization_data) }}
                            <label class="form-check-label ms-2">
                                Autorizo o armazenamento dos meus dados
                            </label>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="form-check">
                            {{ createCheckboxReadOnly('authorization_contact', $contact->authorization_contact) }}
                            <label class="form-check-label ms-2">
                                Permito que a empresa entre em contato comigo
                            </label>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="form-check">
                            {{ createCheckboxReadOnly('authorization_newsletter', $contact->authorization_newsletter) }}
                            <label class="form-check-label ms-2">
                                Quero receber notícias sobre a empresa e seus produtos/serviços
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ONDE TRABALHA -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i class="fas fa-building me-2"></i>ONDE TRABALHA
                    </h5>
                </div>
                <div class="card-body">
                    @if (!$contact->companies()->exists())
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Não possui empresa cadastrada
                            {{ createButtonPlus('company.create', 'criar uma empresa', 'typeCompanies', 'cliente') }}
                        </p>
                    @else
                        @foreach ($contact->companies as $company)
                            <div class="info-row d-flex align-items-center">
                                <a href="{{ route('company.show', ['company' => $company->id]) }}"
                                    class="btn btn-sm me-2"
                                    style="background-color: {{ $principalColor }}; color: white;">
                                    <i class='fa fa-eye'></i>
                                </a>
                                <span>{{ $company->name }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- OPORTUNIDADES -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i
                            class="fas fa-handshake me-2"></i>OPORTUNIDADES</h5>
                </div>
                <div class="card-body">
                    @if ($contact->opportunities->count() > 0)
                        @foreach ($contact->opportunities as $opportunity)
                            <div class="info-row d-flex align-items-center">
                                <a href="{{ route('opportunity.show', ['opportunity' => $opportunity->id]) }}"
                                    class="btn btn-sm me-2"
                                    style="background-color: {{ $principalColor }}; color: white;">
                                    <i class='fa fa-eye'></i>
                                </a>
                                <span>{{ $opportunity->name }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Nenhuma oportunidade cadastrada
                        </p>
                    @endif
                </div>
            </div>

            <!-- IMAGENS -->
            <div class="card mb-4">
                <div class="card-header" style="background-color: {{ $principalColor }}; color: white !important;">
                    <h5 class="mb-0" style="color: white !important;"><i class="fas fa-images me-2"></i>IMAGENS
                        ENVIADAS</h5>
                </div>
                <div class="card-body">
                    @if ($contact->images->count() > 0)
                        <div class="row">
                            @foreach ($contact->images as $image)
                                <div class="col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('image.show', ['image' => $image->id]) }}" class="me-2">
                                            <img src='{{ asset($image->path) }}' class="img-thumbnail"
                                                style='width: 60px; height:60px; object-fit: cover;'>
                                        </a>
                                        <span class="small">{{ $image->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Nenhuma imagem enviada
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection



@section('workflow')
    <div class='row'>
        <div class='col'>
            <button id='' class='workflow-button-red' title='Encerrar tarefa com a data atual' type='submit'>
                <a style='text-decoration: none;color: white;display: inline-block'
                    href="{{ route('task.create', [
                        'contact' => $contact,
                        'name' => "Vender para $contact->first_name",
                        'department' => 'vendas',
                    ]) }}">
                    <i class="fas fa-funnel-dollar" style="font-size:30px; color:white;padding-bottom: 10px"></i>
                    <br>
                    CRIAR OPORTUNIDADE
                </a>
            </button>
        </div>
    </div>
@endsection

@extends('layouts/show')

@section('title','CONTATOS')

@section('image-top')
{{ asset('images/contact.png') }} 
@endsection


@section('buttons')
{{createButtonEdit('contact', 'contact', $contact)}}
{{createButtonList('contact')}}
@endsection

@section('name', $contact->name)


@section('priority')
<div class="high pe-2 d-flex justify-content-end">{{$contact->points}} pontos</div>
@endsection


@section('status')
{{formatShowStatus($contact)}}
@endsection

@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        ORIGEM
    </div>

</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    @if(isset($contact->lead_source))
    <a href='{{route('contact.show', ['contact' => $contact])}}'>
        <div class='show-field-end'>
            {{$contact->lead_source}}
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
        {{date('d/m/Y H:i', strtotime($contact->created_at))}}
    </div>
</div>
@endsection

@section('description')
{{$contact->observations}}
@endsection

@section('main')
<div class="row mt-5">
    <div class="col-6">
        <h2 class="name" for="">PESSOAL</h2>
        <label class="labels"  for="" >Primeiro nome: </label> {{$contact->first_name}}
        <br>
        <label class="labels"  for="" >Sobrenome: </label> {{$contact->last_name}}
        <br>
        <label class="labels"  for="" >Data de nascimento: </label> {{$contact->date_birth}}
        <br>
        <label class="labels"  for="" >CPF: </label> {{$contact->cpf}}
        <br>
        <br>

        <h2 class="name" for="">PROFISSIONAL</h2>
        <label class="labels"  for="" >Profissão: </label> {{ $contact->profession }}
        <br>
        <label class="labels"  for="" >Empresa: </label> {{ $contact->company }}
        <br>
        <label class="labels"  for="" >Cargo: </label> {{ $contact->job_position }}
        <br>
        <label class="labels"  for="" >Escolaridade: </label> {{ $contact->schollarity }}
        <br>

        <br>
        <br>
        <h2 class="name" for="">CONTATOS</h2>
        <label class="labels"  for="" >Email: </label> {{ $contact->email}}
        <br>
        <label class="labels"  for="">Telefone: </label> {{ $contact->phone}}
        <br>
        <label class="labels"  for="">Site: </label> {{ $contact->site}}
        <br>
        <label class="labels"  for="">Instagram: </label> {{ $contact->instagram}}
        <br>
        <label class="labels"  for="">Facebook: </label> {{ $contact->facebook}}
        <br>
        <label class="labels"  for="">Linkedin: </label> {{ $contact->linkedin}}
        <br>
        <label class="labels"  for="">Twitter: </label> {{ $contact->twitter}}
        <br>
        <br>
        <br>
        <h2 class="name" for="">LOCALIZAÇÃO</h2>
        <label class="labels" for="">Endereço: </label> {{ $contact->address}}
        <br>
        <label class="labels" for="">Cidade: </label> {{ $contact->city}}
        <br>
        <label class="labels" for="">Bairro: </label> {{ $contact->neighborhood}}
        <br>
        <label class="labels"  for="">Estado: </label> {{ $contact->state}}
        <br>
        <label class="labels"  for="">País: </label> {{ $contact->country}}
        <br>
        <label class="labels"  for="">CEP: </label> {{ $contact->zip_code}}
        <br>
        <br>
        <br>
        <h2 class="name" for="">PERFIL</h2>
        <label class="labels"  for="">Estado civil:  </label>
        {{ $contact->civil_state}}
        <br>
        <label class="labels"  for="">Naturalidade:  </label>
        {{ $contact->naturality}}
        <br>
        <label class="labels"  for="">Filhos:  </label>
        {{ $contact->kids}}
        <br>
        <label class="labels"  for="">Hobbie:  </label>
        {{ $contact->hobbie}}
        <br>
        <label class="labels"  for="">Renda:  </label>
        {{ $contact->income}}
        <br>
        <label class="labels"  for="">Religião:  </label>
        {{ $contact->religion}}
        <br>
        <label class="labels"  for="">Etinia:  </label>
        {{ $contact->etinicity}}
        <br>
        <label class="labels"  for="">Gênero:  </label>
        {{ $contact->gender}}
        <br>

    </div>
    <div class="col-6">
        <div class='row'>
            <div class='show-label-large col'>
                AUTORIZAÇÕES
            </div>
            <div class='description-field'>

                <div class="row">
                    <div class="col-2">
                        <label class="labels"  for="">Dados pessoais:</label>
                    </div>
                    <div class="col-10">
                        {{createCheckboxReadOnly('authorization_data', $contact->authorization_data)}} Autorizo o armazenamento dos meus dados.
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label class="labels"  for="">Contato:</label>
                    </div>
                    <div class="col-10">
                        {{createCheckboxReadOnly('authorization_contact', $contact->authorization_contact)}} Permito que a empresa entre em contato comigo.
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label class="labels"  for="">Newsletter:</label>
                    </div>
                    <div class="col-10">
                        {{createCheckboxReadOnly('authorization_newsletter', $contact->authorization_newsletter)}}  Quero receber notícias sobre a empresa e seus produtos/serviços.
                    </div>
                </div>
            </div>
        </div>

        <div class='row mt-5'>
            <div class='show-label-large col'>
                ONDE TRABALHA:
            </div>
            <div class='description-field'>
                @if(!$contact->companies()->exists())
                <p>
                    Não possui empresa cadastrada
                    {{createButtonPlus('company.create', 'criar um ponto forte da empresa', 'typeCompanies', 'cliente')}}
                </p>
                @else
                @foreach ($contact->companies as $company)
                <a  class="white" href=" {{route('company.show', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                {{$company->name}}
                <br>
                @endforeach	
                @endif
            </div>
        </div>

        <div class='row mt-5'>
            <div class='show-label-large col'>
                OPORTUNIDADES:
            </div>
            <div class='description-field'>
                @foreach ($contact->opportunities as $opportunity)
                <div class="row">
                    <a  class="white" href=" {{route('opportunity.show', ['opportunity' => $opportunity->id])}}">
                        <button class="button-round">
                            <i class='fa fa-eye'></i>
                        </button>
                    </a>
                    {{$opportunity->name}}
                </div>
                @endforeach	
            </div>
        </div>



        <div class='row mt-5'>
            <div class='show-label-large col'>
                IMAGENS ENVIADAS PELO CONTATO:
            </div>
            <div class='description-field'>
                <div class="row mt-3">
                    @foreach($contact->images as $image)
                    <div class="col-6">
                        <a  class="white" href=" {{route('image.show', ['image' => $image->id])}}">
                            <img src='{{asset($image->path)}}' style='width: 50px; height:50px'>
                        </a>
                        {{$image->name}}
                    </div>
                    @endforeach
                </div>
            </div>

            @foreach ($contact->opportunities as $opportunity)
            <div class="row">
                <div class='col'>
                    <a  class="white" href=" {{route('opportunity.show', ['opportunity' => $opportunity->id])}}">
                        <button class="button-round">
                            <i class='fa fa-eye'></i>
                        </button>
                    </a>
                    {{$opportunity->name}}
                </div>
            </div>
            @endforeach	
        </div>
    </div>
    @endsection



    @section('workflow')
    <div class='row'>
        <div class='col'>
            <div class='emergency-display'>
                <a style='text-decoration: none;color: black;display: inline-block' href="{{route('contact.create', [
                                                                                                                                                                            'contact' => $contact,
                                                                                                                                                                            'name' => "Vender para $contact->first_name",
                                                                                                                                                                            'department' => 'vendas',
                                                                                                                                                                          ])}}">
                    <p class='panel-text p-3 mb-2'>
                        <i class="fas fa-funnel-dollar" style="font-size:36px; color:white;padding-bottom: 10px"></i>
                        <br>
                        CRIAR OPORTUNIDADE DE VENDA
                    </p>
                </a>
            </div>
        </div>
    </div>
    @endsection
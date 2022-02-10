@extends('layouts/show')

@section('title','MINHA EMPRESA')

@section('image-top')
{{asset('images/empresa.png')}} 
@endsection

@section('buttons')
{{createButtonEdit('account', 'account', $account)}}

@endsection

@section('name', $account->name)


@section('priority', $priority)


@section('status', $status)


@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DONO
    </div>
    <div class='show-label'>
        VENCIMENTO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    @if($owner)
    <a href='{{route('user.show', ['user' => $owner])}}'>
        <div class='show-field-end'>
            {{$owner->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        --
    </div>
    @endif
            <div class='show-field-end'>
            {{$account->due_date}}
        </div>
</div>

<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        CRIADA EM
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end d-flex justify-content-end'>
        {{date('d/m/Y H:i', strtotime($account->created_at))}}
    </div>
</div>
@endsection

@section('description')
{{$account->description}}
@endsection


@section('main')
<div class="row mt-5">
    <div class="col-6">
        <div class='col d-flex justify-content-start'>
            <label class="labels"  for="" >
                CNPJ: 
            </label>
            <div id="cnpj">
                {{formatCnpj($account->cnpj)}}  
            </div>
            <button type="button" class="button-round primary" onclick="copyData(cnpj)">
                <i class="fa fa-clone" aria-hidden="true"></i>
            </button>
        </div>
        <label class="labels"  for="" >
            Email:
        </label>
        {{$account->email}}
        <br>
        <label class="labels"  for="" >
            Telefone:
        </label>
        {{$account->phone}}
        <br>
        <label class="labels"  for="" >
            WhatsApp para vendas:
        </label>
        {{$account->whatsapp_sales}}
        <br>
        <label class="labels"  for="" >
            Site:
        </label>
        {{$account->site}}
        <br>
        <br>
        <br>
        <label class="labels"  for="" >
            Endereço:
        </label>
        {{$account->address}}
        <br>
        <label class="labels"  for="" >
            Cidade:
        </label>
        {{$account->city}}
        <br>
        <label class="labels"  for="" >
            Estado:
        </label>
        {{$account->state}}
        <br>
        <label class="labels"  for="" >
            País:
        </label>
        {{$account->country}}
        <br>
        <label class="labels"  for="" >
            CEP:
        </label>
        {{$account->zip_code}}
        <br>
        <br>
        <label class="labels"  for="" >
            Setor:
        </label>
        {{$account->sector}}
        <br>
        <label class="labels"  for="" >
            Qtde empregados:
        </label>
        {{$account->employees}}
        <br>
        <label class="labels"  for="" >
            Faturamento:
        </label>
        {{$account->revenues}}
        <br>
        <br>
        <label class="labels"  for="" >
            Diferencial competitivo:
        </label>
        {{$account->competitive_advantage}}
        <br>
        <label class="labels"  for="" >
            Modelo de neǵocio:
        </label>
        {{$account->business_model}}
    </div>

    <div class="col-6">
        <div class='row mt-0'>
            <div class='show-label-large col'>
                FUNCIONÁRIOS:
            </div>
            <div class='description-field'>
                @foreach ($account->users as $user)
                <a  class="white" href=" {{route('user.show', ['user' => $user])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                {{$user->contact->name}}
                <br>
                @endforeach	
            </div>
        </div>

        
            <div class='row mt-4'>
                <div class='show-label-large col'>
                    IDENTIDADE VISUAL:
                </div>
                <div class='description-field'>
                    <p class="labels"">
                        Logomarca:
                        @if($account->image)
                        <img src="{{asset($account->image->path)}}" width="180px" height="60px" style="background-color:gainsboro;border-radius: 10px">
                        @else
                        não possui
                        @endif
                    </p>
                    <p class="labels"">
                        Cor principal: 
                        <button type="button" style="color:white;background-color:{{$account->principal_color}};display: inline-block;border-radius:50%">P</button> {{$account->principal_color}}
                    </p>
                    <p class="labels"">
                        Cor complementar: 
                        <button type="button" style="color:white;background-color:{{$account->complementary_color}};display: inline-block;border-radius:50%">C</button> {{$account->complementary_color}}
                    </p>
                    <p class="labels"">
                        Cor secundária: 
                        <button type="button" style="color:{{$account->principal_color}};background-color:{{$account->opposite_color}};display: inline-block;border-radius:50%">O</button> {{$account->opposite_color}}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-scripts')
<script>
    function copyData(containerid) {
        var range = document.createRange();
        range.selectNode(cnpj); //changed here
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
    }
</script>
@endsection
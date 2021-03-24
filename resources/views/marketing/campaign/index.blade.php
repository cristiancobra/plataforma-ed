@extends('layouts/master')

@section('title','CAMPANHAS')

@section('image-top')
{{asset('imagens/campaign.png')}} 
@endsection

@section('description')
Total: <span class="labels">{{$total}}</span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('campaign.create')}}">
    CRIAR
</a>
@endsection

@section('main')
<div style="text-align: right">
    <form action="{{route('campaign.index')}}" method="post" style="color: #874983;display: inline-block">
        @csrf
        <input type="text" name="name" placeholder="nome do contato" value="">
        <select class="select" name="account_id">
            <option  class="select" value="">
                Qualquer empresa
            </option>
            @foreach ($accounts as $account)
            <option  class="select" value="{{$account->id}}">
                {{$account->name}}
            </option>
            @endforeach
            <option  class="select" value="">
                todas
            </option>
        </select>
        <input class="button-secondary" type="submit" value="FILTRAR">
    </form>
</div>
<br>
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 20%">
                NOME
            </td>
            <td   class="table-list-header" style="width: 25%">
                EMPRESA
            </td>
            <td   class="table-list-header" style="width: 25%">
                EMAIL
            </td>
            <td   class="table-list-header" style="width: 15%">
                TELEFONE
            </td>
            <td   class="table-list-header" style="width: 15%">
                DONO
            </td>
        </tr>

        @foreach($campaigns as $campaign)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <a class="white" href=" {{route('campaign.show', ['campaign' => $campaign->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('campaign.edit', ['campaign' => $campaign->id])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$campaign->name}}
            </td>
            <td class="table-list-left">
                @if($campaign->companies)
                @foreach($campaign->companies as $company)
                <a class="white" href=" {{route('company.show', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('company.edit', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$company->name}}
                <br>
                @endforeach
                @else
                Não possui
                @endif
            </td>
            <td class="table-list-left">
                {{$campaign->email}}
                <a class="white" href="">
                    <button class="button-round">
                        <i class='fa fa-envelope'></i>
                    </button>
                </a>
            </td>
            <td class="table-list-right">
                {{$campaign->phone}}
            </td>
            <td class="table-list-center">
                {{$campaign->account->name}}
            </td>
        </tr>
        @endforeach
    </table>
    <p style="text-align: right">
        <br>
        {{$campaigns->links()}}
    </p>
    <br>
    @endsection
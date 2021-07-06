@extends('layouts/master')

@section('title',' PÚBLICO-ALVO')

@section('image-top')
{{ asset('images/contact.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contact')}}
@endsection

@section('main')
<div class="row mt-3 ms-2">
    <div class="name col-6 text-center">
        {{$totalContacts}} CONTATOS
    </div>
    <div class="name col-6">
        {{$totalClients}} CLIENTES
    </div>
</div>
<div class="row">
    <div class="col-6">
        {{createTablePercentual('ORIGEM DO CONTATO', $sourcesTotals)}}
        {{createTablePercentual('PROFISSÃO', $professionsTotals)}}
        {{createTablePercentual('ETINIA', $etinicityTotals)}}
        {{createTablePercentual('RELIGIÃO', $religionTotals)}}
        {{createTablePercentual('GÊNERO', $genderTypesTotals)}}
        {{createTablePercentual('HOBBIES', $hobbiesTotals)}}
    </div>
    <div class="col-6">
    </div>
</div>
@endsection
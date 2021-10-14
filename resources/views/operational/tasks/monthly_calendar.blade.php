@extends('layouts/master')

@section('title','AGENDA')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-1 me-1'>
    <div class='col tb-header-start'>
        SEGUNDA
    </div>
    <div class='col tb-header'>
        TERÇA
    </div>
    <div class='col tb-header'>
        QUARTA
    </div>
    <div class='col tb-header'>
        QUINTA
    </div>
    <div class='col tb-header'>
        SEXTA
    </div>
    <div class='col tb-header'>
        SÁBADO
    </div>
    <div class='col tb-header-end'>
        DOMINGO
    </div>
</div>
<div class='row mt-2 mb-3 ms-1 me-1'>  
    @while($totalDays > $counter)
    <div class='col'>
        {{$counter++}}
    </div>
    @endwhile
</div>

@endsection
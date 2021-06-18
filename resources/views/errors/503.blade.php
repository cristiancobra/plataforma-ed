@extends('errors::illustrated-layout')

@section('title', __('Temporariamente fora de serviço'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Ops...desculpe-nos... voltaremos em minutos.'))


@section('image')
<img src="{{asset('/imagens/logo-empresa-digital.png')}}" width="600px" height="200px">
@endsection
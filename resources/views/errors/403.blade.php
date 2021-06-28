@extends('errors::illustrated-layout')

@section('title', __('Sem permissão de acesso'))
@section('code', 'erro 403')
@section('message', __($exception->getMessage() ?: 'Sem permissão de acesso'))

@section('image')
<img src="{{asset('/images/logo-empresa-digital.png')}}" width="600px" height="200px">
@endsection
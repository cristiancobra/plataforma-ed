@extends('layouts/master')

@section('title','CONCORRENTES')

@section('image-top')
{{asset('imagens/competitors.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button primary'  href='{{route('competitor.create')}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('main')
<div>
    <p class='subtitulo-roxo' style='text-align: right;padding-top: 2%;padding-right: 6%'>
        Você possui <span class='labels'>{{$totalCompetitors}} contas </span>
    </p>
    <br>
    <table class='table-list'>
        <tr>
            <td class='table-list-header'>
                Nome
            </td>
            <td class='table-list-header'>
                Facebook
            </td>
            <td class='table-list-header'>
                Instagram
            </td>
            <td class='table-list-header'>
                Linkedin
            </td>
            <td class='table-list-header'>
                Twitter
            </td>
            <td class='table-list-header'>
                Pinterest
            </td>
        </tr>

        @foreach ($competitors as $competitor)
        <tr style='font-size: 14px'>
            <td class='table-list-left'>
                <button class='button-round'>
                    <a href=' {{route('competitor.show', ['competitor' => $competitor->id])}}'>
                        <i class='fa fa-eye' style='color:white'></i></a>
                </button>
                {{$competitor->name}}
            </td>

            <td class='table-list-right'>
                {{$competitor->facebook_followers}}
            </td>

            <td class='table-list-right'>
                {{$competitor->instagram_followers}}
            </td>

            <td class='table-list-right'>
                {{$competitor->linkedin_followers}}
            </td>

            <td class='table-list-right'>
                {{$competitor->twitter_followers}}
            </td>

            <td class='table-list-right'>
                {{$competitor->pinterest_followers}}
            </td>

        </tr>
        @endforeach
    </table>
    <p style='text-align: right'>
        <br>
        {{$competitors->links()}}
    </p>
    <br>
    @endsection
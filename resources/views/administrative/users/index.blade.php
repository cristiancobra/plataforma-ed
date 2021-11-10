@extends('layouts/master')

@section('title', 'FUNCIONÁRIOS')

@section('image-top')
{{asset('images/user.png')}} 
@endsection

@section('description')
@isset($total)
Total: <span class='labels'>{{$total}} </span>
@endisset
@endsection

@section('buttons')
<a class='circular-button secondary'  href='{{route('user.index')}}'>
    <i class='fas fa-arrow-left'></i>
</a>
<a class='circular-button primary'  href='{{route('user.create')}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('main')
<div style='text-align: right'>
    <form action='{{route('user.index')}}' method='post' style='color: #874983;display: inline-block'>
        @csrf
        <input type='text' name='user_name' placeholder='nome ou sobrenome' value=''>
        <input class='btn btn-secondary' type='submit' value='FILTRAR'>
    </form>
</div>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header'>
            FOTO 
        </td>
        <td   class='table-list-header'>
            NOME 
        </td>
        <td   class='table-list-header'>
            EMAIL
        </td>
    </tr>

    @foreach ($users as $user)
    <tr style='font-size: 16px'>
        <td class='table-list-center'>
            <div class='profile-picture-small'>
                <a  class='white' href='{{route('user.show', ['user' => $user->id])}}'>
                    @if($user->image)
                    <img src='{{asset($user->image->path)}}' width='100%' height='100%'>
                    @else
                    <img src='{{asset('images/user.png')}}' width='100%' height='100%'>
                    @endif
                </a>
            </div>
        </td>
        <td class='table-list-left'>

            <a  class='white' href=' {{route('user.show', ['user' => $user->id])}}'>
                <button class='button-round'>
                    <i class='fa fa-eye'></i>
                </button>
            </a>
            {{$user->contact->name}}
        </td>

        <td class='table-list-left'>
            <a style='color: #874983' href=' mailto:{{$user->email}} ' target='_blank'>
                <button class='button-round'>
                    <i class='fa fa-envelope'></i>
                </button> {{$user->email }}
            </a>
        </td>
    </tr>
    @endforeach
</table>
<br>
<p style='text-align: right'>
    <br>
    {{$users->links()}}
</p>
<br>
@endsection
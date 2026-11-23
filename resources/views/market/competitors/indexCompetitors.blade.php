@extends('layouts/index')

@section('title', 'CONCORRENTES')

@section('image-top')
    <i class="fas fa-trophy"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a class='circular-button primary' href='{{ route('competitor.create') }}'>
        <i class='fa fa-plus' aria-hidden='true'></i>
    </a>
@endsection

@section('table')
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
            <tr class="row-link" data-href="{{ route('competitor.show', ['competitor' => $competitor->id]) }}" style='font-size: 14px'>
                <td class='table-list-left'>
                    
                    {{ $competitor->name }}
                </td>

                <td class='table-list-right'>
                    {{ $competitor->facebook_followers }}
                </td>

                <td class='table-list-right'>
                    {{ $competitor->instagram_followers }}
                </td>

                <td class='table-list-right'>
                    {{ $competitor->linkedin_followers }}
                </td>

                <td class='table-list-right'>
                    {{ $competitor->twitter_followers }}
                </td>

                <td class='table-list-right'>
                    {{ $competitor->pinterest_followers }}
                </td>

            </tr>
        @endforeach
    </table>
    <p style='text-align: right'>
        <br>
        {{ $competitors->links() }}
    </p>
    <br>
@endsection

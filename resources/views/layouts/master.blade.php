@extends('layouts/sidebar')

<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> @yield('title') </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link href="{{asset('css/dashboard.css')}}" rel="stylesheet">
        <link href="{{asset('css/list.css')}}" rel="stylesheet">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{asset('js/general.js')}}" async defer></script>
        <script src="{{asset('js/app.js')}}" defer></script>
        <script src="{{asset('js/menu.js')}}" async defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body>

@include('layouts.menu')
        
@include('layouts.sidebar')

                <div class="header">
                    <table style="border-style: none">
                        <tr>
                            <td id="image" style="text-align: center;width: 40px;margin: 0;padding: 0;vertical-align: top">
                                <img src= @yield('image-top') width="40px" height="40px">
                            </td>
                            <td id="title">
                                <h1 style="text-align: left;padding: 0px;margin-bottom: -4px">
                                    @yield('title')
                                </h1>
                            </td>

                            <td id="button" style="text-align: right">
                                @yield('buttons')
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: left">
                                @yield('description')
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="main">
                    @yield('main')
                </div>
                @yield('js-scripts')
    </body>
</html>

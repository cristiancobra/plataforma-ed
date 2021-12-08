@extends('layouts/master')

@section('title','SUPORTE')

@section('image-top')
{{asset('images/marketing.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row'>

    <div class='col-10'>
        <div class="row">
            <div class='col p-3 d-flex justify-content-start' style="
                 border-radius: 8px 8px 0px 0px;
                 border-style: solid;
                 background-color: {{$oppositeColor}};
                 border-color: {{$oppositeColor}};
                 ">
                <a style='text-decoration:none' href='{{route('systemText.indexTutorials')}}'>
                    <p class='panel-text fs-3'>
                        <i class="fas fa-question-circle" style="
                           font-size:36px;
                           color:white;
                           padding-bottom: 10px;
                           padding-right: 10px
                           ">
                        </i>
                        TUTORIAIS
                    </p>
                </a>
            </div>
        </div>
        <div class="row p-5" style="
             border-style: solid;
             border-color: {{$oppositeColor}};
             border-radius: 0px 0px 8px 8px;
             ">
            @foreach($tutorials as $tutorial)
            <div class='row table2 position-relative' style="border-color: {{$oppositeColor}}">
                <a class='stretched-link' href=' {{route('systemText.show', ['systemText' => $tutorial->id])}}'>
                </a>
                <div class='col fs-5'>
                    {{$tutorial->name}}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class='col-2'>
        <div class='sales-display'>
            <a style='text-decoration:none' href='{{route('task.bug')}}'>
                <p class='panel-text'>
                    <i class="fas fa-bug" style="font-size:36px; ; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                    <br>
                    RELATAR BUG
                </p>
            </a>
        </div>

        <div class='sales-display mt-3'>
            <a style='text-decoration:none' target='_blank' href='https://api.whatsapp.com/send?phone=5516981076049&text=Gostaria%20de%20falar%20sobre%20marketing%20digital'>
                <p class='panel-text'>
                    <i class="fas fa-phone" style="font-size:36px; color:white;margin-top: -15px;padding-bottom: 10px"></i>
                    <br>
                    AJUDA WHATSAPP
                </p>
            </a>
        </div>
    </div>

</div>

<div class='row mt-2 mb-3 ms-1 me-1'>


</div>

@endsection
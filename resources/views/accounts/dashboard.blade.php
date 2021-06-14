@extends('layouts/master')

@section('title','MODELO DE NEGÓCIO')

@section('image-top')
{{asset('imagens/control-panel.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button secondary'  href='{{route('task.create')}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('main')
<div class='row mt-3 mb-5 ms-2 me-2'>


<div class='row mt-2 mb-2'>
    <div class='col-lg-2 text-center mx-auto mt-auto mb-auto'>
        <img src='{{asset('imagens/tarefas.png')}}' width='40' height='40'>
        <p class="mt-2">
            {{$account->name}}
            <br>
            {{$account->type}}
        </p>
    </div>

    <div class='col-lg-3 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
            <p class='panel-number'>

            </p>
            <p class='panel-text'>
                 {{$account->description}}
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block tasks-my'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => Auth::user()->id,
				])}}'>
            <p class='panel-number'>

            </p>
            <p class='panel-text'>
                minhas
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block text-center tasks-now'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'feito',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
            <p class='panel-number'>

            </p>
            <p class='panel-text'>
                feitas
            </p>
        </a>
    </div>
</div>


</div>
<br>
<br>
@endsection
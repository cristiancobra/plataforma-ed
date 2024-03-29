@extends('layouts/show')

@section('title','METAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonTrash($goal, 'goal')}}
{{createButtonEdit('goal', 'goal', $goal)}}
{{createButtonList('goal')}}
@endsection

@section('name', $goal->name)


@section('priority', $priority)


@section('status', $status)



@section('fieldsId')
<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        TIPO DE META
    </div>
    <div class='show-label'>
        META
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    <div class='show-field-end'>
        {{$goal->type}}
    </div>
    <div class='show-field-end'>
        {{$goalSelected}}
    </div>
</div>

<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    <div class='show-field-end'>
        {{$goal->department}}
    </div>
</div>
@endsection


@section('description')

{!!html_entity_decode($goal->description)!!}

<br>
<br>
@endsection

@section('main')
<div class='row mt-5'>
    <div class='col-6 pt-4 pb-3' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-left-style: solid;
         border-left-width: 1px;
         border-radius: 7px 0px 0px 0px;
         border-color: #c28dbf
         '>
        <img src='{{asset('images/production.png')}}' width='25px' height='25px'>
        <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >
            PROJETOS
        </label>
    </div>
    <div class='col-6 pt-4 pb-3 d-flex justify-content-end' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-right-style: solid;
         border-right-width: 1px;
         border-radius: 0px 7px 0px 0px;
         border-color: #c28dbf
         '>
        <button id='buttonStageAdd' class='circular-button primary' title='Criar projeto' onclick='toogleAddForm("addProject")'>
            <i class='fa fa-plus' id='buttonOnOff' aria-hidden='true'></i>
        </button>
    </div>
</div>


<!--   div oculta ADICIONAR PROJETO (opportunity) -->
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div class='row pt-5 pb-5' id='addProject' style='display: none;
     border-left-style: solid;
     border-left-width: 1px;
     border-right-style: solid;
     border-right-width: 1px;
     border-color: {{$principalColor}};
     '>
    <div class="row">
        <div class='col-3' style='text-align:left'>
            <form id='addProject' action='{{route('project.store')}}' method='post' style='text-align: left'>
                @csrf
                <input type='hidden' name='goal_id' value='{{$goal->id}}'>
                <input type='hidden' name='type' value='projeto'>
                <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                    NOME DO PROJETO
                </label>
                <br>
                <input type='text' name='name'  placeholder='nome' value=''>
                </div>
                <div class='col-2' style='text-align:left'>

                    <label class="labels" for="" >DATA DE CRIAÇÃO:</label>
                    <input type="date" name="date_start" value="{{date('Y-m-d')}}">
                    @if ($errors->has('date_start'))
                    <span class="text-danger">{{ $errors->first('date_start') }}</span>
                    @endif
                    <br>
                </div>
                <div class='col-3' style='text-align:left'>
                    <label class="labels" for="" >PRAZO FINAL:</label>
                    <br>
                    @if(!empty(app('request')->input('date_due')))
                    <input type="date" name="date_due" value="{{app('request')->input('date_due')}}">
                    @else
                    <input type="date" name="date_due" value="{{old('date_due')}}">
                    @endif
                    <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                    @if ($errors->has('date_due'))
                    <span class="text-danger">{{$errors->first('date_due')}}</span>
                    @endif
                    <br>
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class='labels' for='user_id' style='text-align:left;color:{{$principalColor}}'>
                        RESPONSÁVEL
                    </label>
                    <br>
                    {{createSelectUsers('select', $allUsers)}}
                </div>
                <div class='col-2' style='text-align:left'>
                    <label class='labels' for='status' style='text-align:left;color:{{$principalColor}}'>
                        SITUAÇÃO
                    </label>
                    <br>
                    {{createFilterSelect('status', 'select', $allStatus)}}
                </div>
        </div>
        <div class="row pt-5">
            <div class='col-5' style='text-align:left'>
                <label class='labels' for='name' style='text-align:left;color:{{$principalColor}}'>
                    DESCRIÇÃO
                </label>
            </div>
        </div>
        <div class="row pt-1">
            <div class='col' style='text-align:left'>
                @if ($errors->has('description'))
                <span class="text-danger">{{$errors->first('description')}}</span>
                @endif
                <textarea id="description" name="description" rows="20" cols="90">
  {{old('description')}}
                </textarea>
                <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
                <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
                <script>
CKEDITOR.replace('description');
                </script>
            </div>
        </div>
        <div class="row pt-4">
            <div class='col d-flex justify-content-end'>
                {{createButtonSave()}}
            </div>
            </form>
        </div>
    </div>


    <!--cabeçalho--> 
    <div class="row table-header" style="background-color: {{$principalColor}}">
        <div class='col-1'>
            RESPONSÁVEL 
        </div>
        <div class='col-1'>
            CRIAÇÃO 
        </div>
        <div class='col-4'>
            PROJETO 
        </div>
        <div class='col-4'>
            DESCRIÇÃO 
        </div>
        <div class='col-1'>
            CONCLUSÃO
        </div>
        <div class='col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($projects as $project)
    <div class="row table2 position-relative"  style="
         color: {{$principalColor}};
         border-left-color: {{$complementaryColor}}
         ">
        <a class="stretched-link "href=" {{route('project.show', ['project' => $project])}}">
        </a>
        <div class='cel col-1'>
            @if(isset($project->user->image))
            <div class='profile-picture-small'>
                <img src='{{asset($project->user->image->path)}}' width='100%' height='100%'>
            </div>
            @elseif(isset($project->user->contact->name))
            {{$project->user->contact->name}}
            @else
            funcionário excluído
            @endif
        </div>
        <div class='cel col-1'>
            {{date('d/m/Y', strtotime($project->date_start))}}
        </div>
        <div class='cel col-4'>
            {{$project->name}}
        </div>
        <div class='cel-description col-4'>
            {!!html_entity_decode($project->description)!!}
        </div>

        {{formatDateDue($project)}}

        {{formatStatus($project)}}
    </div>
</a>
@endforeach
@endsection


@section('editButton', route('goal.edit', ['goal' => $goal->id]))

@section('backButton', route('goal.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($goal->created_at))}}
    </div>
</div>
@endsection




@section('js-scripts')
@endsection

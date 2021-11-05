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

@section('priority')
{{formatShowType($goal)}}
@endsection


@section('status')
{{formatShowStatus($goal)}}
@endsection


@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        TIPO DE META
    </div>
    <div class='show-label'>
        META
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        {{$goal->type}}
    </div>
    <div class='show-field-end'>
        {{$goalSelected}}
    </div>
</div>

<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
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
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >EXECUÇÃO</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-right-style: solid;
             border-right-width: 1px;
             border-radius: 0px 7px 0px 0px;
             border-color: #c28dbf
             '>
            <a class='circular-button primary' style='display: inline-block;float: right' href='{{route('opportunity.create', [
                                                                                                                                                                                        'department' => 'desenvolvimento',
                                                                                                                                                                                        'type' => 'projeto',
                                                                                                                                                                                        ]
                    )}}'>
                <i class='fa fa-plus' aria-hidden='true'></i>
            </a>
        </div>
    </div>
    <div class='row'>
        <div class='col-2 tb tb-header'>
            CRIAÇÃO 
        </div>
        <div class='col-3 tb tb-header'>
            TAREFA 
        </div>
        <div class='col-4 tb tb-header'>
            DESCRIÇÃO 
        </div>
        <div class='col-1 tb tb-header'>
            CONCLUSÃO
        </div>
        <div class='col-1 tb tb-header'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($projects as $project)
    <div class='row'>
        <div class='tb col-2'>
            <button class='button-round'>
                <a href=' {{ route('opportunity.show', [
                                                                            'opportunity' => $project->id,
                                                                            'department' => 'desenvolvimento',
                                                                            ])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{date('d/m/Y', strtotime($project->date_start))}}
        </div>
        <div class='tb col-3'>
            {{$project->name}}
        </div>
        <div class='tb-description col-4'>
            {!!html_entity_decode($project->description)!!}
        </div>

        {{formatDateDue($project)}}

        {{formatStatus($project)}}
    </div>
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

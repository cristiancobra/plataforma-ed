@extends('layouts/master')

@section('title','ADMINISTRADOR')

@section('image-top')
{{asset('imagens/control-panel.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('task.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div class='row mt-2 mb-2'>
    <div class="col-lg-2 d-inline-block text-center">
        <img src="{{asset('imagens/tarefas.png')}}" width="40" height="40">
        <br>
        <br>
        TAREFAS
    </div>

    <div class="col-lg-3 d-inline-block tasks-toDo">
        <a style="text-decoration:none" href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => "all",
				])}}">
            <p class="numeros_painel">
                {{$tasks_pending}}
            </p>
            <p class="subtitulo-branco">
                equipe
            </p>
        </a>
    </div>

    <div class="col-lg-3 d-inline-block tasks-my">
        <a style="text-decoration:none" href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
            <p class="numeros_painel">
                {{$tasks_my}}
            </p>
            <p class="subtitulo-branco">
                minhas
            </p>
        </a>
    </div>

    <div class="col-lg-3 d-inline-block text-center tasks-now">
        <a style="text-decoration:none" href="{{route('task.index', [
				'status' =>"feito",
				'contact_id' => "",
				'user_id' => "",
				])}}">
            <p class="numeros_painel">
                {{$tasksDone}}
            </p>
            <p class="subtitulo-branco">
                feitas
            </p>
        </a>
    </div>
</div>

<div class='row mt-5 mb-5'>
    <div class="col-lg-2 d-inline-block text-center">
        <img src="{{asset('imagens/financeiro.png')}}" width="40" height="40">
        <br>
        <br>
        OPORTUNIDADES
    </div>
    <div class="col-lg-7 d-inline-block opportunities-funnel">
        <div class="funnel-bar-prospecting">
            <a style="text-decoration:none;color:white" href="{{route('opportunity.index', [
				'stage' =>"prospecção",
				'contact_id' => "",
				'user_id' => "",
				])}}">
                PROSPECTAR: {{$opportunitiesProspecting}}
            </a>
        </div>
        <div class="funnel-bar-presentation">
            <a style="text-decoration:none;color:white" href="{{route('opportunity.index', [
				'stage' =>"apresentação",
				'contact_id' => "",
				'user_id' => "",
				])}}">
                APRESENTAR: {{$opportunitiesPresentation}}
            </a>
        </div>
        <div class="funnel-bar-proposal">
            <a style="text-decoration:none;color:white" href="{{route('opportunity.index', [
				'stage' =>"proposta",
				'contact_id' => "",
				'user_id' => "",
				])}}">
                PROPOSTA: {{$opportunitiesProposal}}
            </a>
        </div>
    </div>

    <div class="col-2 d-inline-block triangle-text" style="display: inline-block;position: relative">
        <div class="balance-won mx-auto">
            <a style="text-decoration:none" href="{{route('opportunity.index', [
				'stage' =>"ganhamos",
				'contact_id' => "",
				'user_id' => "",
				])}}">
                <p class="balance_number">
                    {{$opportunitiesWon}}
                </p>
                <p class="balance_label_won">
                    ganhamos
                </p>
            </a>
        </div>
        <div id="triangle-text"  style="display: inline-block;position: relative">
            <div class="balance-lost  mx-auto">
                <a style="text-decoration:none" href="{{route('opportunity.index', [
				'stage' =>"perdemos",
				'contact_id' => "",
				'user_id' => "",
				])}}">
                    <p class="balance_number" style="margin-left: -20px">
                        {{$opportunitiesLost}}
                    </p>
                    <p class="balance_label_lost">
                        perdemos
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>

<div class='row mt-2 mb-2'>
    <div class="col-lg-2 d-inline-block text-center">
        <img src="{{asset('imagens/journey.png')}}" width="40" height="40">
        <br>
        <br>
        JORNADAS
    </div>
    <div class="col-lg-10 d-inline-block">
        <table class="table-list">
            <tr>
                <td   class="table-list-header" style="width: 40%">
                    FUNCIONÁRIO 
                </td>
                <td   class="table-list-header" style="width: 10%">
                    HOJE					
                </td>
                <td   class="table-list-header" style="width: 10%">
                    {{strtoupper($month)}}
                </td>
            </tr>

            @foreach ($users as $user)
            <tr style="font-size: 14px">
                <td class="table-list-left">
                    <a class="white" href=" {{route('user.show', ['user' => $user->id])}}">
                        <button class="button-round">
                            <i class='fa fa-eye'></i>
                        </button>
                    </a>
                    {{$user->contact->name}}
                </td>
                <td class="table-list-center">
                    <a class="white" href=" {{route('journey.filter', [
                                                                                            'user_id' => $user->id,
                                                                                            'date_start' => date('Y-m-d'),
                                                                                            'date_end' => date('Y-m-d'),
                                                                                            ])}}">
                        {{number_format($user->hoursToday / 3600, 1, ',','.')}}
                    </a>
                </td>
                <td class="table-list-center">
                    <a class="white" href=" {{route('journey.filter', [
                                                                                            'user_id' => $user->id,
                                                                                            'date_start' => date('Y-m-1'),
                                                                                            'date_end' => date('Y-m-31'),
                                                                                            ])}}">
                        {{number_format($user->hoursMonthly / 3600, 1, ',','.')}}
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<br>
<br>
@endsection
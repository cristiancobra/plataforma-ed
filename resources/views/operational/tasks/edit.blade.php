@extends('layouts/edit')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}} 
@endsection


@section('form_start')
<form action=' {{route('task.update', ['task' => $task])}} ' method='post'>
    @csrf
    @method('put')
    @endsection


    @section('buttons')
    <a class='circular-button secondary'  title='Cancelar alterações' href='{{url()->previous()}}'>
        <i class='fas fa-times-circle'></i>
    </a>
    <button id='' class='circular-button primary' title='Salvar alterações' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
        <i class='fas fa-save'></i>
    </button>
    @endsection


    @section('name')
    NOME:
    @if ($errors->has('name'))
    <input type="text" name="name" size="60" value="{{old('name')}}">
    <span class="text-danger">{{$errors->first('name')}}</span>
    @else
    <input type="text" name="name" size="60" value="{{$task->name}}">
    @endif
    @endsection


    @section('priority')
    PRIORIDADE:
    <br>
    {{createSimpleSelect('priority', 'fields', $priorities, $task->priority)}}
    @endsection


    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', $status, $task->status)}}
    @endsection


    @section('label1', 'CONTATO')
    @section('content1')
    <select name="contact_id"  style='width:100%'>
        @if(!isset($task->contact->name))
        <option  class="fields" value="">
            contato excluído
        </option>
        @else
        <option  class="fields" value="{{$task->contact_id}}">
            {{$task->contact->name}}
        </option>
        @endif
        @foreach ($contacts as $contact)
        <option  class="fields" value="{{$contact->id}}">
            {{$contact->name}}
        </option>
        @endforeach
    </select>
    @endsection


    @section('label2', 'EMPRESA')
    @section('content2')
    @if($task->company_id)
    {{editDoubleSelectIdName('company_id', '', $companies, $task->company->name, 'Não possui')}}
    @else
    {{editDoubleSelectIdName('company_id', '', $companies, null, 'Não possui')}}
    @endif
    @endsection


    @section('label3', 'OPORTUNIDADE')
    @section('content3')
    {{createSelectIdName('opportunity_id', 'fields', $opportunities, 'Não possui', $task->opportunity)}}
    @endsection


    @section('label4', 'RESPONSÁVEL')
    @section('content4')
    <select name="user_id">
        @if(!isset($task->user->contact->name))
        <option  class="fields" value="">
            contato excluído
        </option>
        @else
        <option  class="fields" value="{{$task->user->id}}">
            {{$task->user->contact->name}}
        </option>
        @foreach ($users as $user)
        <option  class="fields" value="{{$user->id}}">
            {{$user->contact->name}}
        </option>
        @endforeach
        @endif
    </select>
    @endsection


    @section('label4', 'DEPARTAMENTO')
    @section('content3')
    {{createSimpleSelect('department', 'fields', $departments, $task->department)}}
    @endsection


    @section('label5', 'PROJETO')
    @section('content5')
    @if($projects)
    <select id='project_id' class = 'fields' name='project_id' style='width:100%'>
        @if($task->project)
        <option value='{{$task->project_id}}'>
            {{$task->project->name}}
        </option>
        @endif
        <option value=''>
            Não possui
        </option>
        @foreach ($projects as $project)
        <option value='{{$project->id}}'>
            {{$project->name}}
        </option>
        @endforeach
    </select>
    @else
    não existe nenhum projeto
    @endif
    @endsection


    @section('label6', 'ETAPA')
    @section('content6')
    <select id='stage_id' name='stage_id' class = 'fields' style='width:100%'>
        <option value=''>Não possui</option>
    </select>
    @endsection


    @section('label7', 'PONTOS')
    @section('content7')
    <input type='number' name='points' value='{{$task->points}}' style="text-align: right;width: 100px">
    @endsection



    @section('date_start')
    <div class='circle-date-start'>
        <input type="date" name="date_start" size="20" value="{{$task->date_start}}">
        @if ($errors->has('date_start'))
        <span class='text-danger'>{{$errors->first('date_start')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        INÍCIO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        <input type="date" name="date_due" size="20" value="{{date('Y-m-d', strtotime($task->date_due))}}">
        <input type="time" name="time_due" size="50"  value="{{date('H:i', strtotime($task->date_due))}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        PRAZO
    </p>
    @endsection


    @section('date_conclusion')
    <div class='circle-date-due'>
        <input type="date" name="date_conclusion" size="20" value="{{$task->date_conclusion}}">
        @if ($errors->has('date_conclusion'))
        <span class="text-danger">{{$errors->first('date_conclusion')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CONCLUSÃO
    </p>
    @endsection






    @section('description')
    <br>
    @if ($errors->has('description'))
    <span class='text-danger'>{{$errors->first('text')}}</span>
    @endif
    <textarea id='text' name='description' rows='20' cols='120'>
  {{$task->description}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace('description');
    </script>
    @endsection


    @section('main')
    @if(Session::has('failed'))
    <div class='alert alert-danger'>
        {{Session::get('failed')}}
        @php
        Session::forget('failed');
        @endphp
    </div>
    @endif
    <div>
        <div class='row mt-4'>
            <div class="col">
                <label class='labels' for='' >ANEXAR IMAGEM:</label>
                <input type='file' name='image'>
            </div>
        </div>
    </div>




    <!--script-->



    @endsection



    @push('scripts')
    <script src='{{url(mix('js/scripts.js'))}}'></script>
    @endpush


    @section('footer-scripts')
    <script>
            loadProjectStagesJson('project_id', 'stage_id', '/projetos/jsonStages', '{{$task->stage_id}}');
    </script>
    @endsection


    <!--    
        [11:48, 23/11/2021] Giordano: tem dois select na view, ele vai ficar vendo o valor de um pra mudar as opções do outro
    [11:48, 23/11/2021] Giordano: as opções do outro tão num json que vc passa o valor do primeiro select
    [11:48, 23/11/2021] Giordano: são selects pais e filhos
    [11:48, 23/11/2021] Giordano: tipo estado cidade
    [11:49, 23/11/2021] Giordano: na função principal vc passa os ids desses selects e a url do json
    [11:50, 23/11/2021] Giordano: aí chama essa url, passando o valor do select pai
    [11:51, 23/11/2021] Giordano: qdo chega a resposta ele limpa as opções do filho e completa com oq veio do json
    [11:51, 23/11/2021] Giordano: essa função tb tem a opção de vc passar o valor que já tá definido no select filho. Ele verifica se passou esse valor e atribui depois da primeira chamada do json

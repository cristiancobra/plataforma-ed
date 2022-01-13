@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('task')}}
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action=" {{route('task.store')}} " method="post" enctype='multipart/form-data'>
        @csrf
        <div class='row pt-3'>
            <div class='col-6'>

                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            NOME:
                        </label>
                    </div>
                    <div class='col-9'>
                        @if($name)
                        <input type="text" name="name" value="{{$name}}" style="width: 450px">
                        @else
                        <input type="text" name="name" style="width: 450px" value="{{old('name')}}">
                        @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                        @endif
                    </div>
                </div>
                <br>

                @if($department)
                <input type="hidden" name="department"value="{{$department}}">
                @else
                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            DEPARTAMENTO:
                        </label>
                    </div>
                    <div class='col-9'>
                        @if(!empty(app('request')->input('department')))
                        {{app('request')->input('department')}}
                        <input type="hidden" name="department"value="{{app('request')->input('department')}}">
                        @elseif($errors->has('department'))
                        <span class="text-danger">{{$errors->first('department')}}</span>
                        @else
                        {{createSimpleSelect('department', 'fields', $departments)}}
                        @endif
                    </div>
                </div>
                @endif

                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            RESPONSÁVEL: 
                        </label>
                    </div>
                    <div class='col-9'>
                        {{createSelectUsers('fields', $users)}}
                    </div>
                </div>


                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            OPORTUNIDADE:
                        </label>
                    </div>
                    <div class='col-9'>
                        @if(!empty(app('request')->input('opportunity_id')))
                        {{app('request')->input('opportunity_name')}}
                        <input type="hidden" name="opportunity_id" value="{{app('request')->input('opportunity_id')}}">
                        @else
                        <select class = 'fields' name='opportunity_id' style='width:700px'>
                            <option value=''>
                                Não possui
                            </option>
                            @foreach ($opportunities as $opportunity)
                            @if(old('opportunity_id') == $opportunity->id)
                            <option value='{{$opportunity->id}}' selected='selected'>
                                {{$opportunity->name}}
                            </option>
                            @endif
                            <option value='{{$opportunity->id}}'>
                                {{$opportunity->date_start}}  //  

                                @if($opportunity->company)
                                {{$opportunity->company->name}}  --
                                @endif

                                @if($opportunity->contact)
                                {{$opportunity->contact->name}}
                                @endif

                                --  {{$opportunity->name}}
                            </option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                </div>


                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            CONTATO: 
                        </label>
                    </div>
                    <div class='col-9'>
                        @if($contact)
                        <input type="hidden" name="contact_id" value=" {{$contact->id}}">
                        {{$contact->name}}
                        @else
                        {{createDoubleSelectIdName('contact_id', 'fields', $contacts)}}
                        @endif
                    </div>
                </div>

                @if(app('request')->input('department') != 'desenvolvimento')
                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            EMPRESA: 
                        </label>
                    </div>
                    <div class='col-9'>
                        @if(!empty(app('request')->input('company_id')))
                        <input type="hidden" name="company_id" value="{{app('request')->input('company_id')}}">
                        {{app('request')->input('company_name')}}
                        @else
                        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física')}}
                        @endif
                    </div>
                </div>
                @endif

                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            PRIORIDADE:
                        </label>
                    </div>
                    <div class='col-9'>
                        {{createSimpleSelect('priority', 'fields', $priorities)}}
                    </div>
                </div>

                <div class='row'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            DATA DE CRIAÇÃO:
                        </label>
                    </div>
                    <div class='col-9'>
                        <input type="date" name="date_start" value="{{$today}}">
                        @if ($errors->has('date_start'))
                        <span class="text-danger">{{ $errors->first('date_start') }}</span>
                        @endif
                    </div>
                </div>

                <div class='row mt-4'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            PRAZO FINAL:
                        </label>
                    </div>
                    <div class='col-9'>
                        @if(!empty(app('request')->input('date_due')))
                        <input type="date" name="date_due" value="{{app('request')->input('date_due')}}">
                        @else
                        <input type="date" name="date_due" value="{{old('date_due') ? old('date_due') : $dateDue}}">
                        @endif
                        <input type="time" name="time_due" size="50"  value="{{old('time_due')}}">
                        @if ($errors->has('date_due'))
                        <span class="text-danger">{{$errors->first('date_due')}}</span>
                        @endif
                    </div>
                </div>


                <div class='row mt-4'>
                    <div class='col-3'>
                        <label class="labels" for="" >
                            PONTOS:
                        </label>
                    </div>
                    <div class='col-9'>
                        <input type='number' value='{{old('points')}}' style="text-align: right;width: 100px">
                    </div>
                </div>

                <div class='row mt-4'>
                    <div class='col-3'>
                        <label class='labels' for='' >
                            ANEXAR IMAGEM:
                        </label>
                    </div>
                    <div class='col-9'>
                        <input type='file' name='image'>
                    </div>
                </div>

            </div>


            <div class='col-6'>
                <div class='row'>
                    <div class='col'>
                        <label class="labels" for="" >
                            DESCRIÇÃO:
                        </label>
                    </div>
                </div>
                @if ($errors->has('description'))
                <span class="text-danger">{{$errors->first('description')}}</span>
                @endif
                <div class='row mt-3'>
                    <div class='col'>
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
            </div>
        </div>

        <div class='row mt-5'>
            <div class='col'>
                <p style="text-align: right">
                    <input class="btn btn-secondary" type="submit" value="CRIAR TAREFA">
                </p>
            </div>
        </div>
    </form>
</div>
@endsection
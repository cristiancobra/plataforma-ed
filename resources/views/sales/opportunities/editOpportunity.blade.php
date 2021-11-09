@extends('layouts/master')

@section('title', $title)

@section('image-top')
{{asset('images/financeiro.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonList('opportunity', 'department',  $opportunity->department)}}
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
    <form action=" {{route('opportunity.update', ['opportunity' =>$opportunity->id])}} " method="post">
        @csrf
        @method('put')
        @if($opportunity->department == 'desenvolvimento')
        <input type="hidden" name="department" value="{{$opportunity->department}}">
        @endif
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20" value="{{$opportunity->name}}">
        @if ($errors->has('name'))
        <span class="text-danger">{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class="labels" for="" >RESPONSÁVEL: </label>
        <select name="user_id">
            <option  class="fields" value="{{$opportunity->user_id}}">
                {{$opportunity->user->contact->name}}
            </option>
            @foreach ($users as $user)
            <option  class="fields" value="{{$user->id}}">
                {{$user->name}}
            </option>
            @endforeach
        </select>
        <br>
        <br>
                        @if($opportunity->department != 'desenvolvimento')
        <label class="labels" for="" >EMPRESA: </label>
        @if(isset($opportunity->company))
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física', $opportunity->company)}}
        @else
        {{createDoubleSelectIdName('company_id', 'fields', $companies, 'Pessoa física')}}
        @endif
        <br>
        @endif
        <label class="labels" for="" >CONTATO: </label>
        <select name="contact_id">
            @if(isset($opportunity->contact_id))
            <option  class="fields" value="{{$opportunity->contact_id}}">
                {{$opportunity->contact->name}}
            </option>
            @else
            <option  class="fields" value="">
                não possui
            </option>
            @endif
            @foreach ($contacts as $contact)
            <option  class="fields" value="{{$contact->id}}">
                {{$contact->name}}
            </option>
            @endforeach
        </select>
        <br>
        <label class="labels" for="" >
            DATA DE CRIAÇÃO:
        </label>
        <input type="date" name="date_start" size="20" value="{{$opportunity->date_start}}">
        <br>
                <label class="labels" for="" >
                    PRAZO FINAL:
                </label>
        <input type="date" name="date_due" size="20" value="{{old('date_due')}}">
        @if ($errors->has('date_due'))
        <span class="text-danger">{{$errors->first('date_due')}}</span>
        @endif
        <br>
        <br>
        <label class="labels" for="" >
            DESCRIÇÃO:
        </label>
        <textarea id="description" name="description" rows="20" cols="90">
		{{$opportunity->description}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <br>
                @if($stages != null)
        <label class="labels" for="">ETAPA DA VENDA:</label>
        {{createSimpleSelect('stage', 'fields', $stages, $opportunity->stage)}}
        <br>
        @endif
        
        <label class="labels" for="" >DATA DE CONCLUSÃO:</label>
        <input type="date" name="date_conclusion" size="20" value="{{$opportunity->date_conclusion}}">
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status, $opportunity->status)}}
        <br>
        <br>
        <div style="text-align: right">
            <input class="btn btn-secondary" style="float:right;text-align: right;margin-left: 5px" type="submit" value="SALVAR">
            </form>
            <form   style="text-decoration: none;display: inline-block" action="{{route('opportunity.destroy', ['opportunity' => $opportunity->id])}}" method="post">
                @csrf
                @method('delete')
                <input class="btn btn-danger" type="submit" value="APAGAR">
            </form>
            <a class="btn btn-secondary" href=" {{route('opportunity.index')}} "  style="text-decoration: none;color: white;display: inline-block">
                <i class='fas fa-arrow-alt-circle-left'></i><i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <br>
        </div>
        <br>
        <br>
        @endsection
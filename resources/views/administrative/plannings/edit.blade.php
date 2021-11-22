@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection

@section('buttons')

{{createButtonList('planning')}}
@endsection

@section('main')
<div>
    <form action=" {{ route('planning.update', ['planning' =>$planning->id]) }} " method="post">
        @csrf
        @method('put')
        <label class="labels" for="" >NOME:</label>
        <input type="text" name="name" size="20" value="{{$planning->name}}">
        <br>
        <label class='labels' for='' >DATA DE CRIAÇÃO:</label>
        <input type='date' name='date_creation' size='20'  value="{{$planning->date_creation}}">
        <br>
        <br>
        <label class="labels" for="" >PREVISÃO EM MESES:</label>
        <input type="integer" name="months" size="5" min="1" max="24" value='{{$planning->months}}' style="text-align: right">
        <br>
        <br>
        <label class="labels" for="" >DESPESAS MENSAIS: R$</label>
        <input type="integer" name="expenses" size="5" value='{{$planning->expenses}}' style="text-align: right">
                <br>
        <label class="labels" for="" >CRESCIMENTO DA DESPESA:</label>
        <input type="decimal" name="increased_expenses" size="5" max="24" value='{{$planning->increased_expenses}}' style="text-align: right"> %
        <br>
        <p class="fields" for="" >Previsao do aumento mensal das depesas em percentual</p>
        <br>
        <div>
            <label class="labels" for="" >PREVISÃO CRESCIMENTO:</label>
            <input type="decimal" name="growth_rate" size="5" max="24"  value='{{$planning->growth_rate}}'  style="text-align: right"> %
            <br>
            <p class="fields" for="" >Previsão de crescimento das vendas em percentual</p>
            <br>
        <br>
        <br>
        <label class="labels" for="" >DESCRIÇÃO:</label>
        <textarea id="observations" name="observations" rows="20" cols="90">
		{{ $planning->observations }}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('observations');
        </script>
        <br>
        <br>
        <br>
        <label class="labels" for="">SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', returnStatusActive(), $planning->status)}}
        <br>
        <br>
        <input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

    </form>
</div>
<br>
<br>
@endsection
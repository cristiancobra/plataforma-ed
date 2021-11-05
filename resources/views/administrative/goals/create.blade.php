@extends('layouts/master')

@section('title','METAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('goal')}}
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
    <form action=' {{route('goal.store')}} ' method='post' enctype='multipart/form-data'>
        @csrf
        <label class='labels' for='' >NOME:</label>
        <input type='text' name='name' style='width: 600px' value='{{old('name')}}'>
        @if ($errors->has('name'))
        <span class='text-danger'>{{$errors->first('name')}}</span>
        @endif
        <br>
        <label class='labels' for='' >DEPARTAMENTO:</label>
        {{createSimpleSelect('department', 'fields', $departments)}}
        @if ($errors->has('department'))
        <span class='text-danger'>{{$errors->first('department')}}</span>
        @endif
        <br>
        <br>
            <label class="labels" for="" >INÍCIO:</label>
        <input type="date" name="date_start" value="{{old('date_start') ? old('date_start') : date('Y-m-d')}}">
        @if ($errors->has('date_start'))
        <span class="text-danger">{{$errors->first('date_start')}}</span>
        @endif
        <br>
        <br>
        <div class='row'>
            <div class='col'>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='execução' value='execução'>
            <label class='form-check-label pt-2 ms-2' for='execução' style="
                                                                                                                    text-align: right;
                                                                                                                    font-weight:600;
                                                                                                                    color: {{$principalColor}}
                                                                                                                     ">
                EXECUÇÃO:
            </label>
            <p class='form-check-label pt-2 ms-2' for='execução' style="text-align: right">
                concluir todas as tarefas
            </p>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='contatos' value='contatos'>
            <label class='form-check-label pt-2 ms-2' for='execução' style="
                                                                                                                    text-align: right;
                                                                                                                    font-weight:600;
                                                                                                                    color: {{$principalColor}}
                                                                                                                     ">
                MARKETING:
            </label>
            <p class='form-check-label pt-2 ms-2' for='contatos' style="text-align: right">
                aumentar contatos para 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='number' name='goal_contacts'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='receita' value='receita'>
            <label class='form-check-label pt-2 ms-2' for='execução' style="
                                                                                                                    text-align: right;
                                                                                                                    font-weight:600;
                                                                                                                    color: {{$principalColor}}
                                                                                                                     ">
                RECEITA:
            </label>
            <p class='form-check-label pt-2 ms-2' for='receita' style="text-align: right">
                atingir faturamento de
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_revenues'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='despesa'>
            <label class='form-check-label pt-2 ms-2' for='execução' style="
                                                                                                                    text-align: right;
                                                                                                                    font-weight:600;
                                                                                                                    color: {{$principalColor}}
                                                                                                                     ">
                DESPESA:
            </label>
            <p class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right">
                manter despesas abaixo de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_expenses'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='entrada' value='entrada'>
            <label class='form-check-label pt-2 ms-2' for='execução' style="
                                                                                                                    text-align: right;
                                                                                                                    font-weight:600;
                                                                                                                    color: {{$principalColor}}
                                                                                                                     ">
                ENTRADAS:
            </label>
            <p class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right">
                atingir entradas de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_revenues'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='saída'>
            <label class='form-check-label pt-2 ms-2' for='execução' style="
                                                                                                                    text-align: right;
                                                                                                                    font-weight:600;
                                                                                                                    color: {{$principalColor}}
                                                                                                                     ">
                SAÍDAS:
            </label>
            <p class='form-check-label pt-2 ms-2' for='saída' style="text-align: right">
                manter saídas abaixo de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_expenses'>
        </div>
        </div>
        </div>
        <br>
        <br>
        <label class='labels' for='' >DESCRIÇÃO:</label>
        <br>
        @if ($errors->has('description'))
        <span class='text-danger'>{{$errors->first('description')}}</span>
        @endif
        <textarea id='text' name='description' rows='20' cols='90'>
  {{old('text')}}
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('description');
        </script>
        <br>
        <label class='labels' for='' >ANEXAR IMAGEM:</label>
        <input type='file' name='image'>
        <br>
        <br>

        <label class='labels' for='' >SITUAÇÃO:</label>
        {{createSimpleSelect('status', 'fields', $status)}}
        <br>
        <br>
        <p style='text-align: right'>
            <input class='btn btn-secondary' type='submit' value='CRIAR'>
        </p>
    </form>
</div>
<br>
<br>
@endsection


    @section('js-scripts')
    <script>
        $("[name=goal_invoices_revenues]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        $("[name=goal_invoices_expenses]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        $("[name=goal_transactions_revenues]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        $("[name=goal_transactions_expenses]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
    </script>
    @endsection
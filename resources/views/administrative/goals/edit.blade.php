@extends('layouts/edit')

@section('title','METAS')

@section('image-top')
{{ asset('images/text.png') }} 
@endsection

@section('form_start')
<form action=' {{route('goal.update', ['goal' => $goal])}} ' method='post'>
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
    <input type='text' name='name' size='60' style="margin-left: 10px" value='{{$goal->name}}'>
    @endsection


    @section('priority')
    TIPO:

    @endsection


    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', $status, $goal->status)}}
    @endsection

    @section('fieldsId')
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            TIPO DE META
        </div>
    </div>
    <div class='col-lg-5 col-xs-6' style='text-align: center'>
                <div class='show-field-end'>
        @if($goal->type != null)
        <div class='form-check mb-3'>
            <input class='form-check-input' type='radio' name='type' id='{{$goal->type}}' value='{{$goal->type}}' checked>
            <label class='form-check-label' for='{{$goal->type}}''>{{$goal->type}}'</label>
        </div>
        @endif    
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='execução' value='execução' checked>
            <label class='form-check-label pt-2 ms-2' for='execução' style="text-align: right;font-weight:600">EXECUÇÃO:</label>
            <p class='form-check-label pt-2 ms-2' for='execução' style="text-align: right">concluir todas as tarefas</p>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='contatos' value='contatos' checked>
            <label class='form-check-label pt-2 ms-2' for='contatos' style="text-align: right;font-weight:600">MARKETING:</label>
            <p class='form-check-label pt-2 ms-2' for='contatos' style="text-align: right">aumentar contatos para </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='number' name='goal_contacts'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='receita' value='receita' checked>
            <label class='form-check-label pt-2 ms-2' for='receita' style="text-align: right;font-weight:600">RECEITA:</label>
            <p class='form-check-label pt-2 ms-2' for='receita' style="text-align: right">atingir faturamento de </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_revenues'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='despesa' checked>
            <label class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right;font-weight:600">DESPESA:</label>
            <p class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right">manter despesas abaixo de </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_expenses'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='entrada' value='entrada' checked>
            <label class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right;font-weight:600">ENTRADAS:</label>
            <p class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right">atingir entradas de </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_revenues'>
        </div>
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='saída' checked>
            <label class='form-check-label pt-2 ms-2' for='saída' style="text-align: right;font-weight:600">SAÍDAS:</label>
            <p class='form-check-label pt-2 ms-2' for='saída' style="text-align: right">manter saídas abaixo de </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_expenses'>
        </div>
    </div>
    </div>

    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            DEPARTAMENTO
        </div>
    </div>
    <div class='col-lg-3 col-xs-6' style='text-align: center'>
        <div class='show-field-end'>
            {{createSimpleSelect('department', 'fields', $departments, $goal->department)}}
        </div>
    </div>
    @endsection


    @section('description')
    <br>
    @if ($errors->has('text'))
    <span class='text-danger'>{{$errors->first('text')}}</span>
    @endif
    <textarea id='text' name='text' rows='20' cols='120'>
  {{$goal->text}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('text');
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
    @endsection


    @section('js-scripts')
    <script>
        $("[name=goal_invoices_revenues]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        $("[name=goal_invoices_expenses]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        $("[name=goal_transactions_revenues]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
        $("[name=goal_transactions_expenses]").maskMoney({prefix: 'R$ ', allowNegative: true, thousands: '.', decimal: ',', affixesStay: false});
    </script>
    @endsection
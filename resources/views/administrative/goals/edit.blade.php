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
    {{$goal->type}}
    @endsection


    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', $status, $goal->status)}}
    @endsection


    @section('label1', 'DEPARTAMENTO')
    @section('content1')
    {{createSimpleSelect('department', 'fields', $departments, $goal->department)}}
    @endsection


    @section('label2', 'TIPO DE META')
    @section('content2')
    <div class="row ms-2">

        <div class='form-check d-flex justify-content-start'>
            @if($goal->type == 'execução')
            <input class='form-check-input mt-2' type='radio' name='type' id='execução' value='execução' checked>
            @else
            <input class='form-check-input mt-2' type='radio' name='type' id='execução' value='execução' >
            @endif
            <label class='form-check-label pt-2 ms-2' for='execução' style="text-align: right;font-weight:600">
                EXECUÇÃO:
            </label>
        </div>
    </div>
    <div class="row">
        <p class='form-check-label pt-2 ms-2' for='execução' style="text-align: left">
            Concluir todas as tarefas
        </p>
    </div>

    <div class="row ms-2">
        <div class='form-check d-flex justify-content-start'>
            @if($goal->type == 'contatos')
            <input class='form-check-input mt-2' type='radio' name='type' id='contatos' value='contatos' checked>
            @else
            <input class='form-check-input mt-2' type='radio' name='type' id='contatos' value='contatos' >
            @endif
            <label class='form-check-label pt-2 ms-2' for='contatos' style="text-align: right;font-weight:600">
                MARKETING:
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col  d-flex justify-content-end">
            <p class='form-check-label pt-2 ms-2' for='contatos' style="text-align: left">
                aumentar contatos para 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='number' name='goal_contacts'>
        </div>
    </div>

    <div class="row ms-2">
        <div class='form-check d-flex justify-content-start'>
            @if($goal->type == 'receita')
            <input class='form-check-input mt-2' type='radio' name='type' id='receita' value='receita' checked>
            @else
            <input class='form-check-input mt-2' type='radio' name='type' id='receita' value='receita' >
            @endif
            <label class='form-check-label pt-2 ms-2' for='receita' style="text-align: right;font-weight:600">
                RECEITA:
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col  d-flex justify-content-end">
            <p class='form-check-label pt-2 ms-2' for='receita' style="text-align: right">
                atingir faturamento de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_revenues'  id='goal_invoices_revenues' maxlength='11' onkeyup="formatCurrencyReal('goal_invoices_revenues')" value='{{$goal->goal_invoices_revenues}}'>
        </div>
    </div>
    <div class="row ms-2">
        <div class='form-check d-flex justify-content-start'>
                        @if($goal->type == 'despesa')
            <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='despesa' checked>
            @else
            <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='despesa' >
            @endif
            <label class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right;font-weight:600">
                DESPESA:
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col  d-flex justify-content-end">
            <p class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right">
                manter abaixo de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_expenses'  id='goal_invoices_expenses' maxlength='11' onkeyup="formatCurrencyReal('goal_invoices_expenses')" value='{{$goal->goal_invoices_expenses}}'>
        </div>
    </div>
    <div class="row ms-2">
        <div class='form-check d-flex justify-content-start'>
                                    @if($goal->type == 'entrada')
            <input class='form-check-input mt-2' type='radio' name='type' id='entrada' value='entrada' checked>
            @else
            <input class='form-check-input mt-2' type='radio' name='type' id='entrada' value='entrada' >
            @endif
            <label class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right;font-weight:600">
                ENTRADAS:
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col  d-flex justify-content-end">
            <p class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right">
                atingir entradas de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_revenues'  id='goal_transactions_revenues' maxlength='11' onkeyup="formatCurrencyReal('goal_transactions_revenues')" value='{{$goal->goal_transactions_revenues}}'>
        </div>
    </div>
    <div class="row ms-2">
        <div class='form-check d-flex justify-content-start'>
            <input class='form-check-input mt-2' type='radio' name='type' id='saída' value='saída' {{$goal->type == 'saída' ? 'checked' : ''}}'>
            <label class='form-check-label pt-2 ms-2' for='saída' style="text-align: right;font-weight:600">
                SAÍDAS:
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col  d-flex justify-content-end">
            <p class='form-check-label pt-2 ms-2' for='saída' style="text-align: right">
                manter saídas abaixo de 
            </p>
            <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_expenses'  id='goal_transactions_expenses' maxlength='11' onkeyup="formatCurrencyReal('goal_transactions_expenses')" value='{{$goal->goal_transactions_expenses}}'>
        </div>
    </div>
    @endsection


    @section('fieldsId')
    <div class='col-2' style='text-align: center'>
        <div class='show-label'>
            TIPO DE META
        </div>
    </div>
    <div class='col-3' style='text-align: center'>
        <div class='show-field-end'>
            <div class='form-check d-flex justify-content-start'>
                <input class='form-check-input mt-2' type='radio' name='type' id='execução' value='execução' {{$goal->type == 'execução' ? 'checked' : ''}}>
                <label class='form-check-label pt-2 ms-2' for='execução' style="text-align: right;font-weight:600">
                    EXECUÇÃO:
                </label>
                <p class='form-check-label pt-2 ms-2' for='execução' style="text-align: right">
                    concluir todas as tarefas
                </p>
            </div>
            <div class='form-check d-flex justify-content-start'>
                <input class='form-check-input mt-2' type='radio' name='type' id='contatos' value='contatos' {{$goal->type == 'contatos' ? 'checked' : ''}}'>
                <label class='form-check-label pt-2 ms-2' for='contatos' style="text-align: right;font-weight:600">
                    MARKETING:
                </label>
                <p class='form-check-label pt-2 ms-2' for='contatos' style="text-align: right">
                    aumentar contatos para 
                </p>
                <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='number' name='goal_contacts'>
            </div>
            <div class='form-check d-flex justify-content-start'>
                <input class='form-check-input mt-2' type='radio' name='type' id='receita' value='receita' {{$goal->type == 'receita' ? 'checked' : ''}}'>
                <label class='form-check-label pt-2 ms-2' for='receita' style="text-align: right;font-weight:600">
                    RECEITA:
                </label>
                <p class='form-check-label pt-2 ms-2' for='receita' style="text-align: right">
                    atingir faturamento de 
                </p>
                <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_revenues' value='{{$goal->goal_invoices_revenues}}'>
            </div>
            <div class='form-check d-flex justify-content-start'>
                <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='despesa' {{$goal->type == 'despesa' ? 'checked' : ''}}'>
                <label class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right;font-weight:600">
                    DESPESA:
                </label>
                <p class='form-check-label pt-2 ms-2' for='despesa' style="text-align: right">
                    manter despesas abaixo de 
                </p>
                <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_invoices_expenses' value='{{$goal->goal_invoices_expenses}}'>
            </div>
            <div class='form-check d-flex justify-content-start'>
                <input class='form-check-input mt-2' type='radio' name='type' id='entrada' value='entrada' {{$goal->type == 'entrada' ? 'checked' : ''}}'>
                <label class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right;font-weight:600">
                    ENTRADAS:
                </label>
                <p class='form-check-label pt-2 ms-2' for='entrada' style="text-align: right">
                    atingir entradas de 
                </p>
                <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_revenues' value='{{$goal->goal_transactions_revenues}}'>
            </div>
            <div class='form-check d-flex justify-content-start'>
                <input class='form-check-input mt-2' type='radio' name='type' id='despesa' value='saída' {{$goal->type == 'saída' ? 'checked' : ''}}'>
                <label class='form-check-label pt-2 ms-2' for='saída' style="text-align: right;font-weight:600">
                    SAÍDAS:
                </label>
                <p class='form-check-label pt-2 ms-2' for='saída' style="text-align: right">
                    manter saídas abaixo de 
                </p>
                <input class='form-control ms-2 mb-1 me-3' style="text-align: right;width: 140px" type='text' name='goal_transactions_expenses' value='{{$goal->goal_transactions_expenses}}'>
            </div>
        </div>
    </div>

    @endsection



    @section('date_start')
    <div class='circle-date-start'>
        <input type='date' name='date_start' size='20' value='{{date('Y-m-d', strtotime($goal->date_start))}}'>
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
        <input type='date' name='date_due' size='20' value='{{date('Y-m-d', strtotime($goal->date_due))}}'>
        @if ($errors->has('date_due'))
        <span class='text-danger'>{{$errors->first('date_due')}}</span>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        PRAZO
    </p>
    @endsection


    @section('date_conclusion')
    <div class='circle-date-due'>
        <input type='date' name='date_conclusion' size='20' value='{{date('Y-m-d', strtotime($goal->date_conclusion))}}'>
        @if ($errors->has('date_conclusion'))
        <span class='text-danger'>{{$errors->first('date_conclusion')}}</span>
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
  {{$goal->description}}
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
    @endsection


    @section('js-scripts')
    @endsection
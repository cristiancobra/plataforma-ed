@extends('layouts/edit')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection


@section('form_start')
<form action=' {{route('planning.update', ['planning' => $planning])}} ' method='post'>
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
    <input type="text" name="name" size="60" value="{{$planning->name}}">
    @endif
    @endsection    


    @section('priority')
    TIPO:
    <br>

    @endsection


    @section('status')
    SITUAÇÃO:

    @endsection




    @section('label1', 'DATA DE CRIAÇÃO')
    @section('content1')
    <input type='date' name='date_creation' size='20'  value="{{$planning->date_creation}}">
    @endsection


    @section('description')
    <br>
    @if ($errors->has('observations'))
    <span class='text-danger'>{{$errors->first('text')}}</span>
    @endif
    <textarea id='text' name='observations' rows='20' cols='120'>
  {{$planning->observations}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
CKEDITOR.replace('observations');
    </script>
    @endsection



    @section('main')
    <div class="row mt-5">
        <div class="col">
            <label class="labels" for="" >
                PREVISÃO EM MESES:
            </label>
            <input type="integer" name="months" size="5" min="1" max="24" value='{{$planning->months}}' style="text-align: right">
        </div>
    </div>

    <div class='container mt-5 mb-5 pb-4' style='
         border-style: solid;
         border-width: 1px;
         border-color: darkred;
         border-radius: 8px;
         '>
        <div class='row mt-0 pt-3 pb-3'>
            <div class="col">
                <label class="labels" for=""  style='color: darkred'>
                    DESPESAS MENSAIS: R$
                </label>
            </div>
        </div>
         <div class='row mt-2'>
                <div class='col'>
                    <p class="fields" for="" >Previsao de todas as despesas fixas e variáveis (não incluir custos fixos de produtos)</p>
                </div>
            </div>
            <div class='row mt-4'>
                <div class='col-2 labels'>
                    PROLABORE
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_prolabore" id="expenses_prolabore" onkeyup="formatCurrencyReal('expenses_prolabore')" size="15" value='{{formatCurrency($planning->expenses_prolabore)}}' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    SALÁRIO
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_salary" id="expenses_salary" onkeyup="formatCurrencyReal('expenses_salary')" size="15" value='{{formatCurrency($planning->expenses_salary)}}' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    MARKETING
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_marketing"  id="expenses_marketing" onkeyup="formatCurrencyReal('expenses_marketing')"size="15" value='{{formatCurrency($planning->expenses_marketing)}}' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    PRODUÇÃO
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_production" id="expenses_production" onkeyup="formatCurrencyReal('expenses_production')" size="15" value='{{formatCurrency($planning->expenses_production)}}' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    CONTABILIDADE
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_accounting" id="expenses_accounting" onkeyup="formatCurrencyReal('expenses_accounting')" size="15" value='{{formatCurrency($planning->expenses_accounting)}}' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    JURÍDICO
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_legal" id="expenses_legal" onkeyup="formatCurrencyReal('expenses_legal')" size="15" value='{{formatCurrency($planning->expenses_legal)}}' style="text-align: right">
                </div>
            </div>
            <div class='row mt-1'>
                <div class='col-2 labels'>
                    INFRAESTRUTURA
                </div>
                <div class='col-2 justify-content-start'>
                    <input type="integer" name="expenses_infrastructure" id="expenses_infrastructure" onkeyup="formatCurrencyReal('expenses_infrastructure')" size="15" value='{{formatCurrency($planning->expenses_infrastructure)}}' style="text-align: right">
                </div>
                </div>

        <div class='row mt-3 pt-3 pb-3'>
            <div class="col">
                <label class="labels" for=""  style='color: darkred'>
                    CRESCIMENTO DA DESPESA:
                </label>
                <input type="decimal" name="increased_expenses" size="5" max="24" value='{{$planning->increased_expenses}}' style="text-align: right"> %
            </div>
        </div>

        <p class="fields" for="" style='color: darkred'>Previsao do aumento mensal das depesas em percentual</p>
    </div>

    <div class='container mt-5 mb-5 pb-4'  style='
         border-style: solid;
         border-width: 1px;
         border-color: #4863A0;
         border-radius: 8px;
         '>
        <div class='row mt-0 pt-3 pb-3'>
            <div class="col">
                <label class="labels" for=""  style='color: #4863A0'>
                    PREVISÃO CRESCIMENTO:
                </label>
                <input type="decimal" name="growth_rate" size="5" max="24"  value='{{$planning->growth_rate}}'  style="text-align: right"> %
            </div>
        </div>

        <p class="fields" for="" style='color: #4863A0'>
            Previsão de crescimento das vendas em percentual
        </p>
    </div>

    <label class="labels" for="">SITUAÇÃO:</label>
    {{createSimpleSelect('status', 'fields', returnStatusActive(), $planning->status)}}
</div>
@endsection
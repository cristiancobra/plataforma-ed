@extends('layouts/master')

@section('title','MODELOS DE CONTRATO')

@section('image-top')
{{ asset('images/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contractTemplate')}}
@endsection

@section('main')
<div>
    <form action=' {{ route('contractTemplate.store') }} ' method='post' style='padding: 40px;color: #874983'>
        @csrf
        <label class='labels' for='' >NOME DO MODELO:</label>
        <input type='text' name='name'value=''>
        <br>
                <p>
        O início de todos os contratos (itens de 1 a 3) é igual, conforme modelo abaixo.
        </p>
        <div class='row mt-5 mb-5' style='
             padding: 40px;
             color: #874983;
             border-style: solid;
             border-width: 1px;
             border-color: #c28dbf;
             border-radius: 15px;
             '>
            <div class='row mt-2''>
                <h2 style='color: black;font-weight: 600;text-align: center'>
                    NOME DO CONTRATO
                </h2>
            </div>
            <div class='row mt-5'>
                <h3 style='color: black;font-weight: 600'>
                    Objeto do contrato
                </h3>
                <div class='row'>
                    <p style='color: black'>
                        1. É objeto deste contrato o/a << NOME DO CONTRATO >> nos termos aqui descritos.
                    </p>
                </div>
                <div class='row mt-4'>
                    <h3 style='color: black;font-weight: 600'>
                        Identificação das partes
                    </h3>
                </div>
                <div class='row'>
                    <p style='color: black'>
                        2. São partes deste contrato a empresa contratada 
                        <span class='labels'>
                            [NOME DA EMPRESA]
                        </span>
                        inscrita no CNPJ sob o nº
                        <span class='labels'>[CNPJ]</span>.
                        Localizada na
                        <span class='labels'>[RUA]</span>,
                        em
                        <span class='labels'>[CIDADE]</span>,
                        –
                        <span class='labels'>[ESTADO]</span>,
                        CEP
                        <span class='labels'>[CEP]</span>,
                        representada por
                        <span class='labels'>[NOME DO RESPONSÁVEL]</span>
                        ,
                        inscrito no CPF sob o nº
                        <span class='labels'>[CPF]</span>,
                        residente em
                        <span class='labels'>[RUA]</span>,
                        em
                        <span class='labels'>[CIDADE]</span>,
                        /
                        <span class='labels'>[ESTADO]</span>,
                        CEP:
                        <span class='labels'>[CEP]</span> e;
                    </p>
                </div>
            </div>
            <br>
            <p style='color: black'>
                a empresa contratante
                <span class='labels'>
                    [NOME DA EMPRESA]
                </span>
                inscrita no CNPJ sob o nº
                <span class='labels'>[CNPJ]</span>.
                Localizada na
                <span class='labels'>[RUA]</span>,
                em
                <span class='labels'>[CIDADE]</span>,
                –
                <span class='labels'>[ESTADO]</span>,
                CEP
                <span class='labels'>[CEP]</span>,
                representada por
                <span class='labels'>[NOME DO RESPONSÁVEL]</span>
                ,
                inscrito no CPF sob o nº
                <span class='labels'>[CPF]</span>,
                residente em
                <span class='labels'>[RUA]</span>,
                em
                <span class='labels'>[CIDADE]</span>,
                /
                <span class='labels'>[ESTADO]</span>,
                CEP:
                <span class='labels'>[CEP]</span> e;
            </p>
            <div class='row mt-4'>
                <h3 style='color: black;font-weight: 600'>
                    Serviços/produtos contratados
                </h3>
            </div>
            <div class='row'>
                <p style='color: black'>
                    3. Os produtos/serviços contratados e suas especificidades são:
                </p>
            </div>
            <div class='row'>
                <p style='color: black'>
                    <span class='labels'>[LISTA DE ITENS DA FATURA]</span>.
                </p>
            </div>
        <p>
        </div>
        Inicie a numeração do contrato pelo número 4.
        </p>
        <textarea id='text' name='text' rows='20' cols='90'>
        </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
        <script>
CKEDITOR.replace('text');
        </script>
        <br>
        <br>
        <input class='btn btn-secondary' type='submit' value='CRIAR'>
    </form>
</div>     
@endsection
@extends('layouts/edit')

@section('title','PRODUTOS')


@push('scripts')
<script src='{{url(mix('js/scripts.js'))}}'></script>
@endpush


@section('image-top')
{{ asset('images/products.png') }} 
@endsection



@section('form_start')
            <form action='{{route('product.update', ['product' => $product->id, 'variation' => $variation])}}' method='post'>
    @csrf
    @method('put')
    @endsection


    @section('buttons')
    <a class='circular-button secondary'  title='Cancelar alterações' href='{{url()->previous()}}'>
        <i class='fas fa-times-circle'></i>
    </a>
    <button id='' class='circular-button primary' title='Salvar alterações' style='border:none;padding-left:4px;padding-top:2px' 'type='submit'>
        <i class='fas fa-save'></i>
    </button>
    @endsection


    @section('name')
    NOME:
    <input type='text' name='name' size='60' style='margin-left: 10px' value='{{$product->name}}'>
    @endsection


    @section('priority')
    {{createSimpleSelect('status', 'dropdown', $status, $product->status)}}
    @endsection


    @section('status')
    <input type='decimal' id='price' name='price' onkeyup="formatCurrencyReal('price')" style="width:100%;text-align: right" value='{{formatCurrencyReal($product->price)}}'>
    @endsection


    @section('label1', 'CNAE')
    @section('content1')
    <input type='text' name='cnae' size='20' value='{{$product->cnae}}'>
    @endsection


    @section('label2', 'CATEGORIA')
    @section('content2')
    {{createSimpleSelect('category', 'dropdown', $categories, $product->category)}}
    @endsection


    @if($variation == 'despesa')
    @section('label3', 'GRUPO')
    @section('content3')
    {{createSimpleSelect('group', 'dropdown', $groups, $product->group)}}
    @endsection
    @endif


    @if($product->category == 'produto físico')
    @section('label4', 'ESTOQUE INICIAL')
    @section('content4')
    <input type='number' step="1" min='0' name='initial_stock' style="text-align: right" value="{{$product->initial_stock}}">
    @endsection

    @elseif($product->category == 'serviço')
    @section('label4', 'PONTOS FUNCIONAIS')
    @section('content4')
    <input type='decimal' name='points' size='5' value='{{$product->points}}'>
    @endsection

    @endif


    @section('label5', 'HORAS NECESSÁRIAS')
    @section('content5')
    <input type='decimal' name='work_hours' size='5' value='{{$product->work_hours}}'>
    @endsection


    @section('label6', 'IMPOSTO (%)')
    @section('content6')
    <input type='decimal' name='tax_rate' size='5' value='{{$product->tax_rate}}'>
    @endsection


    @section('label7', 'PRAZO DE ENTREGA')
    @section('content7')
    <input type='integer' name='due_date' size='5' value='{{$product->due_date}}'>
    @endsection


    @section('label8', 'DISPONÍVEL NA LOJA')
    @section('content8')
                {{createSelectYesOrNo('', 'shop', $product->shop)}}
    @endsection


    @section('date_start')
    <div class='circle-date-start'>
        <input type='date' name='date_creation' size='20' value='{{$product->created_at}}'>
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
    @endsection


    @section('date_due')
    <div class='circle-date-start'>
        <input type='date' name='date_creation' size='20' value='{{$product->updated_at}}'>
    </div>
    <p class='labels' style='text-align: center'>
        ATUALIZADO
    </p>
    @endsection


    @section('description')
    <textarea id='description' name='description' rows='20' cols='90'>
		{{$product->description}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
    <script>
CKEDITOR.replace('description');
    </script>
    @endsection


    @section('main')
    <div class='row mt-5'>
        <div class='product-image col-6'>
            @if($product->image)
            <img src='{{asset($product->image->path)}}' width='100%' height='100%'>
            @else
            <img src='{{asset('images/products.png')}}'  width='100%' heigh='100%'>
            @endif
        </div>
        <div class='col-6'>
            <div class='row'>
            <div id='change' style='display:inline'>
                <label class='labels' for='' >SELECIONAR IMAGEM:</label>
                {{createSelectIdName('image_id', 'select', $images, 'Nenhuma', $product->image)}}
            </div>
            <div class='row mt-5'>
            <label class='labels' for='' >
                ADICIONAR NOVA IMAGEM:
            </label>
            <label class='switch'>
                <input type='checkbox' id='slider'>
                <span class='slider round'></span>
            </label>
        </div>
    </div>
    </div>
    @endsection

    
    @push('scripts')
    <script src='{{url(mix('js/scripts.js'))}}'></script>
    @endpush


    @section('footer-scripts')
    <script>
       formatCurrencyReal();

// exibir form para adicionar nova imagem
$('#slider').change(function () {
    if (this.checked) {
        $('#change').hide();
        $('#new').show();
    } else {
        $('#change').show();
        $('#new').hide();
    }
});
    </script>
    @endsection

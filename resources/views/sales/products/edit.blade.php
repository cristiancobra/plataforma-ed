@extends('layouts/master')

@if ($variation == 'receita')
    @section('title', 'PRODUTOS')
@else
    @section('title', 'ITENS DE DESPESA')
@endif

@section('image-top')
    <i class="fas fa-box-open"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model="product" parameter="variation" :value="$variation" :principalColor="$principalColor" />
@endsection

@section('main')
    @php
        $opts = fn ($list, $name, $current) => collect($list)->map(
            fn ($v) => "<option value=\"$v\"" . (old($name, $current) == $v ? ' selected' : '') . ">$v</option>"
        )->implode('');
    @endphp
    <form action='{{ route('product.update', ['product' => $product->id, 'variation' => $variation]) }}' method='post'
        enctype='multipart/form-data'>
        @csrf
        @method('put')

        <x-form.section title="IDENTIFICAÇÃO" icon="fas fa-id-card">
            <div class="row">
                <div class="col-md-8">
                    <label class='labels' for='name'>NOME: <span class="text-danger">*</span></label>
                    <input type='text' name='name' id='name' class='form-control' value='{{ old('name', $product->name) }}'>
                    @error('name')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class='labels' for='cnae'>CNAE:</label>
                    <input type='text' name='cnae' id='cnae' class='form-control' value='{{ old('cnae', $product->cnae) }}'>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class='labels' for='category'>CATEGORIA:</label>
                    <select name='category' id='category' class='form-select'>{!! $opts($categories, 'category', $product->category) !!}</select>
                </div>
                @if ($variation == 'despesa')
                    <div class="col-md-4">
                        <label class='labels' for='group'>GRUPO:</label>
                        <select name='group' id='group' class='form-select'>{!! $opts($groups, 'group', $product->group) !!}</select>
                    </div>
                @endif
                <div class="col-md-4">
                    <label class='labels' for='status'>SITUAÇÃO:</label>
                    <select name='status' id='status' class='form-select'>{!! $opts($status, 'status', $product->status) !!}</select>
                </div>
                @if ($product->category == 'produto físico')
                    <div class="col-md-4">
                        <label class='labels' for='initial_stock'>ESTOQUE INICIAL:</label>
                        <input type='number' step='1' min='0' name='initial_stock' id='initial_stock'
                            class='form-control text-end' value='{{ old('initial_stock', $product->initial_stock) }}'>
                    </div>
                @endif
            </div>
        </x-form.section>

        <x-form.section title="IMAGEM" icon="fas fa-image">
            <div class="row align-items-start">
                <div class="col-md-3">
                    <div class="product-image">
                        <img src="{{ $product->image && $product->image->path ? asset($product->image->path) : asset('images/products.png') }}"
                            width="100%" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="col-md-9">
                    <div id='change'>
                        <label class='labels'>SELECIONAR IMAGEM:</label>
                        {{ createSelectIdName('image_id', 'form-select', $images, 'Nenhuma', $product->image) }}
                    </div>
                    <label class='labels d-block mt-3'>ADICIONAR NOVA IMAGEM:</label>
                    <label class='switch'>
                        <input type='checkbox' id='slider'>
                        <span class='slider round'></span>
                    </label>
                    <div id='new' class="mt-2" style='display:none'>
                        <input type='file' name='image' accept='image/*' class='form-control'>
                    </div>
                    @error('image')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-form.section>

        <x-form.section title="DESCRIÇÃO" icon="fas fa-align-left">
            <textarea id='description' name='description' rows='10' class='form-control'>{{ old('description', $product->description) }}</textarea>
            <script>
                Jodit.make('textarea[name="description"]', { language: 'pt_BR' });
            </script>
        </x-form.section>

        <x-form.section title="PRODUÇÃO E VENDA" icon="fas fa-tag">
            <div class="row">
                <div class="col-md-4">
                    <label class='labels' for='price'>PREÇO:</label>
                    <input type='text' name='price' id='price' class='form-control text-end'
                        value='{{ old('price', formatCurrencyReal($product->price)) }}' onkeyup="formatCurrencyReal('price')">
                    @error('price')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class='labels' for='tax_rate'>IMPOSTO (%):</label>
                    <input type='text' name='tax_rate' id='tax_rate' class='form-control text-end'
                        value='{{ old('tax_rate', $product->tax_rate) }}'>
                </div>
                <div class="col-md-4">
                    <label class='labels' for='due_date'>PRAZO DE ENTREGA:</label>
                    <input type='text' name='due_date' id='due_date' class='form-control text-end'
                        value='{{ old('due_date', $product->due_date) }}'>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class='labels' for='work_hours'>HORAS NECESSÁRIAS:</label>
                    <input type='text' name='work_hours' id='work_hours' class='form-control text-end'
                        value='{{ old('work_hours', $product->work_hours) }}'>
                </div>
                @if ($product->category == 'serviço')
                    <div class="col-md-4">
                        <label class='labels' for='points'>PONTOS FUNCIONAIS:</label>
                        <input type='text' name='points' id='points' class='form-control text-end'
                            value='{{ old('points', $product->points) }}'>
                    </div>
                @endif
                <div class="col-md-4">
                    <label class='labels' for='shop'>DISPONÍVEL NA LOJA:</label>
                    <select name='shop' id='shop' class='form-select'>
                        <option value='1' @selected(old('shop', $product->shop) == 1)>sim</option>
                        <option value='0' @selected(old('shop', $product->shop) != 1)>não</option>
                    </select>
                </div>
            </div>
        </x-form.section>

        <div class="mt-4" style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
            <x-buttons.cancel />
            <x-buttons.save :principalColor="$principalColor" />
        </div>
    </form>
@endsection

@section('js-scripts')
    <script>
        document.getElementById('slider').addEventListener('change', function() {
            document.getElementById('change').style.display = this.checked ? 'none' : '';
            document.getElementById('new').style.display = this.checked ? 'block' : 'none';
        });
    </script>
@endsection

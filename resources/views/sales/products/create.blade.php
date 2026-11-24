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
        $opts = fn ($list, $name, $placeholder = null) => collect($list)->map(
            fn ($v) => "<option value=\"$v\"" . (old($name) == $v ? ' selected' : '') . ">$v</option>"
        )->implode('');
    @endphp
    <form action='{{ route('product.store', ['variation' => $variation]) }}' method='post' enctype='multipart/form-data'>
        @csrf

        <x-form.section title="IDENTIFICAÇÃO" icon="fas fa-id-card">
            <div class="row">
                <div class="col-md-8">
                    <x-form.label for="name" required>NOME:</x-form.label>
                    <input type='text' name='name' id='name' class='form-control' value='{{ old('name') }}'>
                    @error('name')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <x-form.label for="cnae">CNAE:</x-form.label>
                    <input type='text' name='cnae' id='cnae' class='form-control' value='{{ old('cnae') }}'>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <x-form.label for="category">CATEGORIA:</x-form.label>
                    <select name='category' id='category' class='form-select'>{!! $opts($categories, 'category') !!}</select>
                </div>
                @if ($variation == 'despesa')
                    <div class="col-md-4">
                        <x-form.label for="group">GRUPO:</x-form.label>
                        <select name='group' id='group' class='form-select'>{!! $opts($groups, 'group') !!}</select>
                    </div>
                @endif
                <div class="col-md-4">
                    <x-form.label for="status">SITUAÇÃO:</x-form.label>
                    <select name='status' id='status' class='form-select'>{!! $opts($status, 'status') !!}</select>
                </div>
                <div class="col-md-4">
                    <x-form.label for="initial_stock">ESTOQUE INICIAL:</x-form.label>
                    <input type='number' min='0' name='initial_stock' id='initial_stock' class='form-control text-end'
                        value='{{ old('initial_stock') }}'>
                    <small class="text-muted">Apenas para produtos físicos</small>
                </div>
            </div>
        </x-form.section>

        <x-form.section title="IMAGEM" icon="fas fa-image">
            <div class="row align-items-end">
                <div class="col-md-6" id='change'>
                    <x-form.label>SELECIONAR IMAGEM:</x-form.label>
                    {{ createSelectIdName('image_id', 'form-select', $images, 'Nenhuma') }}
                </div>
                <div class="col-md-6">
                    <x-form.label class="d-block">ADICIONAR NOVA IMAGEM:</x-form.label>
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
            <textarea id='description' name='description' rows='10' class='form-control'>{{ old('description') }}</textarea>
            <script>
                Jodit.make('textarea[name="description"]', { language: 'pt_BR' });
            </script>
        </x-form.section>

        @if ($variation == 'receita')
            <x-form.section title="PRODUÇÃO E CUSTOS" icon="fas fa-calculator">
                <div class="row">
                    <div class="col-md-4">
                        <x-form.label for="work_hours">HORAS NECESSÁRIAS:</x-form.label>
                        <input type='number' name='work_hours' id='work_hours' class='form-control text-end' min='0'
                            max='999' step='0.1' value='{{ old('work_hours') }}'>
                    </div>
                    <div class="col-md-4">
                        <x-form.label for="points">PONTOS FUNCIONAIS:</x-form.label>
                        <input type='text' name='points' id='points' class='form-control text-end' value='{{ old('points') }}'>
                    </div>
                    <div class="col-md-4">
                        <x-form.label for="tax_rate">IMPOSTO (%):</x-form.label>
                        <input type='text' name='tax_rate' id='tax_rate' class='form-control text-end' value='{{ old('tax_rate') }}'>
                    </div>
                </div>
                @foreach ([1, 2, 3] as $i)
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <x-form.label for="cost{{ $i }}">CUSTO {{ $i }}:</x-form.label>
                            <input type='text' name='cost{{ $i }}' id='cost{{ $i }}'
                                class='form-control text-end' value='{{ old('cost' . $i) }}'>
                        </div>
                        <div class="col-md-8">
                            <x-form.label for="cost{{ $i }}_description">DESCRIÇÃO DO CUSTO {{ $i }}:</x-form.label>
                            <input type='text' name='cost{{ $i }}_description' id='cost{{ $i }}_description'
                                class='form-control' value='{{ old('cost' . $i . '_description') }}'>
                        </div>
                    </div>
                @endforeach
            </x-form.section>
        @endif

        <x-form.section title="VENDA" icon="fas fa-tag">
            <div class="row">
                <div class="col-md-4">
                    <x-form.label for="price">PREÇO:</x-form.label>
                    <input type='text' name='price' id='price' class='form-control text-end' value='{{ old('price') }}'
                        onkeyup="formatCurrencyReal('price')">
                    @error('price')
                        <span class='text-danger'>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <x-form.label for="due_date">PRAZO DE ENTREGA:</x-form.label>
                    <input type='text' name='due_date' id='due_date' class='form-control text-end' value='{{ old('due_date') }}'>
                </div>
            </div>
        </x-form.section>

        <div class="mt-4" style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
            <x-buttons.cancel />
            <x-buttons.save title="Criar produto" />
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

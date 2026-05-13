@extends('layouts/master')

@section('title', 'IMAGENS')

@section('image-top')
    <i class="fas fa-image"></i>
@endsection

@section('description')
@endsection

@section('buttons')

    <x-buttons.list model="image" :object="$image ?? null" :principalColor="$principalColor ?? null" />
@endsection

@section('main')
    <div>
        <form action=" {{ route('image.update', ['image' => $image->id]) }} " method="post" enctype='multipart/form-data'>
            @csrf
            @method('put')
            <div class="container text-center">
                <div class="image-show">
                    <img id="preview" src="{{ asset($image->path) }}" alt="Pré-visualização da imagem" class="img-thumbnail">
                </div>
                <input type="file" name="image" id="image" class="form-control" accept="image/*"
                    onchange="previewImage(event)">
            </div>
            <br>
            <br>
            <label class="labels" for="">RESPONSÁVEL: </label>
            <select name="user_id">
                <option class="fields" value="{{ $image->user_id }}">
                    {{ $image->user->contact->name }}
                </option>
                @foreach ($users as $user)
                    <option class="fields" value="{{ $user->id }}">
                        {{ $user->contact->name }}
                    </option>
                @endforeach
            </select>
            <br>
            <label class="labels" for="">NOME:</label>
            <input type='text' class='fields' name='name' size='50' value='{{ $image->name }}'>
            <br>
            <br>
            <label class="labels" for="">TEXTO ALTERNATIVO:</label>
            <br>
            @if ($errors->has('alt'))
                <span class="text-danger">{{ $errors->first('alt') }}</span>
            @endif
            <textarea id="alt" name="alt" rows="10" cols="90">
{{ $image->alt }}
        </textarea>

            <br>
            <br>
            <label class="labels" for="">TIPO:</label>
            {{ createSimpleSelect('type', 'fields', $types, $image->type) }}
            <br>
            <label class="labels" for="">SITUAÇÃO:</label>
            {{ createSimpleSelect('status', 'fields', $status, $image->status) }}
            <br>
            <br>
            <div>
                <input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">
        </form>
    </div>
    </div>
    <br>
    <br>
@endsection

<script>
    function previewImage(event) {
        const file = event.target.files[0]; // Obtém o arquivo selecionado
        const output = document.getElementById('preview'); // Obtém o elemento <img> para pré-visualização

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                output.src = reader.result; // Atualiza o `src` da imagem com o conteúdo do arquivo
            };
            reader.readAsDataURL(file); // Lê o arquivo como uma URL de dados
        } else {
            // Restaura a imagem original caso nenhum arquivo seja selecionado
            output.src = "{{ asset($image->path) }}";
        }
    }
</script>

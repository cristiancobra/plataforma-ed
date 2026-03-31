@extends('layouts/master')

@section('title', 'IMAGENS')

@section('image-top')
    "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im02LjI1IDE5LjVjLTEuNjAxIDAtMy4wMjUtMS4wMjUtMy41NDItMi41NTFsLS4wMzUtLjExNWMtLjEyMi0uNDA0LS4xNzMtLjc0NC0uMTczLTEuMDg0di02LjgxOGwtMi40MjYgOC4wOThjLS4zMTIgMS4xOTEuMzk5IDIuNDI2IDEuNTkyIDIuNzU1bDE1LjQ2MyA0LjE0MWMuMTkzLjA1LjM4Ni4wNzQuNTc2LjA3NC45OTYgMCAxLjkwNi0uNjYxIDIuMTYxLTEuNjM1bC45MDEtMi44NjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGQ9Im05IDljMS4xMDMgMCAyLS44OTcgMi0ycy0uODk3LTItMi0yLTIgLjg5Ny0yIDIgLjg5NyAyIDIgMnoiIGZpbGw9IiM4NzQ5ODMiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiPjwvcGF0aD48L2c+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjEuNSAyaC0xNWMtMS4zNzggMC0yLjUgMS4xMjItMi41IDIuNXYxMWMwIDEuMzc4IDEuMTIyIDIuNSAyLjUgMi41aDE1YzEuMzc4IDAgMi41LTEuMTIyIDIuNS0yLjV2LTExYzAtMS4zNzgtMS4xMjItMi41LTIuNS0yLjV6bS0xNSAyaDE1Yy4yNzYgMCAuNS4yMjQuNS41djcuMDk5bC0zLjE1OS0zLjY4NmMtLjMzNS0uMzkzLS44Mi0uNjAzLTEuMzQxLS42MTUtLjUxOC4wMDMtMS4wMDQuMjMzLTEuMzM2LjYzMWwtMy43MTQgNC40NTgtMS4yMS0xLjIwN2MtLjY4NC0uNjg0LTEuNzk3LS42ODQtMi40OCAwbC0yLjc2IDIuNzU5di05LjQzOWMwLS4yNzYuMjI0LS41LjUtLjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjwvc3ZnPg=="
@endsection

@section('description')
@endsection

@section('buttons')

    {{ createButtonList('image') }}
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

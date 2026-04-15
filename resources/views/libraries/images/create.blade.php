@extends('layouts/master')

@section('title', 'IMAGENS')

@section('image-top')
    <i class="fas fa-image"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    {{ createButtonList('image') }}
@endsection

@section('main')

    @if (Session::has('failed'))
        <div class="alert alert-danger">
            {{ Session::get('failed') }}
            @php
                Session::forget('failed');
            @endphp
        </div>
    @endif
    <div>
        <form action="{{ route('image.store') }}" method="post" enctype='multipart/form-data'>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="labels" for="image">Imagem:</label>
                    <div class="product-image mb-2">
                        <img id="preview"
                            src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iNTEyIiBoZWlnaHQ9IjUxMiIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiBjbGFzcz0iIj48Zz48ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxnPjxwYXRoIGQ9Im02LjI1IDE5LjVjLTEuNjAxIDAtMy4wMjUtMS4wMjUtMy41NDItMi41NTFsLS4wMzUtLjExNWMtLjEyMi0uNDA0LS4xNzMtLjc0NC0uMTczLTEuMDg0di02LjgxOGwtMi40MjYgOC4wOThjLS4zMTIgMS4xOTEuMzk5IDIuNDI2IDEuNTkyIDIuNzU1bDE1LjQ2MyA0LjE0MWMuMTkzLjA1LjM4Ni4wNzQuNTc2LjA3NC45OTYgMCAxLjkwNi0uNjYxIDIuMTYxLTEuNjM1bC45MDEtMi44NjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjxwYXRoIGQ9Im05IDljMS4xMDMgMCAyLS44OTcgMi0ycy0uODk3LTItMi0yLTIgLjg5Ny0yIDIgLjg5NyAyIDIgMnoiIGZpbGw9IiM4NzQ5ODMiIGRhdGEtb3JpZ2luYWw9IiMwMDAwMDAiIHN0eWxlPSIiIGNsYXNzPSIiPjwvcGF0aD48L2c+PHBhdGggeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBkPSJtMjEuNSAyaC0xNWMtMS4zNzggMC0yLjUgMS4xMjItMi41IDIuNXYxMWMwIDEuMzc4IDEuMTIyIDIuNSAyLjUgMi41aDE1YzEuMzc4IDAgMi41LTEuMTIyIDIuNS0yLjV2LTExYzAtMS4zNzgtMS4xMjItMi41LTIuNS0yLjV6bS0xNSAyaDE1Yy4yNzYgMCAuNS4yMjQuNS41djcuMDk5bC0zLjE1OS0zLjY4NmMtLjMzNS0uMzkzLS44Mi0uNjAzLTEuMzQxLS42MTUtLjUxOC4wMDMtMS4wMDQuMjMzLTEuMzM2LjYzMWwtMy43MTQgNC40NTgtMS4yMS0xLjIwN2MtLjY4NC0uNjg0LTEuNzk3LS42ODQtMi40OCAwbC0yLjc2IDIuNzU5di05LjQzOWMwLS4yNzYuMjI0LS41LjUtLjV6IiBmaWxsPSIjODc0OTgzIiBkYXRhLW9yaWdpbmFsPSIjMDAwMDAwIiBzdHlsZT0iIiBjbGFzcz0iIj48L3BhdGg+PC9nPjwvc3ZnPg=="
                            alt="Pré-visualização da imagem" class="img-thumbnail">
                    </div>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*"
                        onchange="previewImage(event)">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="labels" for="">NOME:</label>
                    <input type='text' class='form-control' name='name' size='50'>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="labels" for="">TEXTO ALTERNATIVO:</label>
                    @if ($errors->has('alt'))
                        <span class="text-danger">{{ $errors->first('alt') }}</span>
                    @endif
                    <textarea id="description" class="form-control" name="alt" rows="6" cols="90"
                        value="{{ old('alt') }}">
        </textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="labels" for="">TIPO:</label>
                    {{ createSimpleSelect('type', 'form-control', $types) }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="labels" for="">SITUAÇÃO:</label>
                    {{ createSimpleSelect('status', 'form-control', $status) }}
                </div>
            </div>
            <input class="btn btn-secondary" type="submit" value="CRIAR">
        </form>
        <br>
        <br>
    </div>
@endsection

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const output = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                output.src = reader.result; // Atualiza a pré-visualização com a imagem carregada
            };
            reader.readAsDataURL(file);
        } else {
            // Restaura a imagem padrão caso nenhum arquivo seja selecionado
            output.src =
                "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEuMSIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnN2Z2pzPSJodHRwOi8vc3ZnanMuY29tL3N2Z2pzIiB3aWR0aD0iMTEwIiBoZWlnaHQ9IjExMCIgeD0iMCIgeT0iMCIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHlsZT0iYm9yZGVyOiAxcHggc29saWQgI2NjYzsgYmFja2dyb3VuZC1jb2xvcjogI2VlZWVlOyBib3JkZXItcmFkaXVzOiA1cHg7Ij4=";
        }
    }
</script>

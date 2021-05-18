@extends('layouts/master')

@section('title','IMAGENS')

@section('image-top')
{{asset('imagens/image.png')}} 
@endsection


@section('buttons')
<a class="circular-button primary"  href="{{route('image.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
    <br>
    <table class="table-list">
        <tr>
            <td   class="table-list-header">
                TÍTULO
            </td>
            <td   class="table-list-header">
                ESCRITO POR 
            </td>
            <td   class="table-list-header">
                Espaço 
            </td>
            <td   class="table-list-header">
                Senha
            </td>
            <td   class="table-list-header">
                Status
            </td>
        </tr>

        @foreach ($images as $image)
        <tr style="font-size: 16px">
            <td class="table-list-left">
                <a class="button-round" href=" https://empresadigital.net.br/webmail" target="_blank">
                    <i class='fa fa-envelope'></i>
                </a>
                <a class="button-round" href=" {{route('image.show', ['image' => $image])}}">
                    <i class='fa fa-eye'></i>
                </a>
                {{$image->title}}
            </td>
            <td class="table-list-center">
                {{$image->user->contact->name}}
            </td>
            <td class="table-list-center">
                {{$image->storage}}
            </td>
            <td class="table-list-center">
                {{$image->image_password}} 
            </td>
            @if ($image->status == "desativado")
            <td class="button-disable">
                {{$image->status }}
            </td>
            @elseif ($image->status == "ativo")
            <td class="button-active">
                {{$image->status }}
            </td>
            @else ($image->status == "pendente")
            <td class="button-delete">
                {{$image->status }}
            </td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
<br>
@endsection

@extends('layouts/master')

@section('title', 'SUPORTE')

@section('image-top')
    <i class="fa fa-bullhorn"></i>
@endsection

@section('buttons')
@endsection

@section('main')
    <div class="row">
        <div class="col-lg-9">
            <x-form.section title="VÍDEOS DEMONSTRATIVOS" icon="fas fa-play-circle" class="mt-2 mb-2">
                {{-- arquivos em public/videos --}}
                <div class="row g-3 align-items-start">
                    <div class="col-md-6">
                        <video controls preload="none" class="w-100 rounded border"
                            poster="{{ asset('videos/demo-acervo-campos-dos-tipos.jpg') }}">
                            <source src="{{ asset('videos/demo-acervo-campos-dos-tipos.mp4') }}" type="video/mp4">
                            Seu navegador não reproduz vídeos.
                            <a href="{{ asset('videos/demo-acervo-campos-dos-tipos.mp4') }}">Baixar o vídeo</a>.
                        </video>
                    </div>
                    <div class="col-md-6">
                        <p class="fw-bold mb-1">ACERVO: campos dos tipos de acervo</p>
                        <p class="text-muted small mb-0">
                            Como criar campos para os tipos de acervo, cadastrar itens com os campos do tipo e
                            usar o campo de senha protegida.
                        </p>
                    </div>
                </div>
            </x-form.section>

            <x-form.section title="TUTORIAIS" icon="fas fa-question-circle">
                @if ($tutorials->isNotEmpty())
                    <div class="list-group list-group-flush">
                        @foreach ($tutorials as $tutorial)
                            <a href="{{ route('systemText.show', ['systemText' => $tutorial->id]) }}"
                                class="list-group-item list-group-item-action px-1">
                                <i class="fas fa-angle-right me-2" style="color: {{ $principalColor }}"></i>
                                {{ $tutorial->name }}
                            </a>
                        @endforeach
                    </div>
                    <div class="mt-2 text-end">
                        <a href="{{ route('systemText.indexTutorials') }}" class="small">ver todos os tutoriais</a>
                    </div>
                @else
                    <p class="text-muted">Nenhum tutorial cadastrado.</p>
                @endif
            </x-form.section>
        </div>

        <div class="col-lg-3">
            <x-form.section title="ATENDIMENTO" icon="fas fa-headset" class="mt-2 mb-2">
                <div class="d-grid gap-2">
                    <a href="{{ route('task.bug') }}" class="btn text-white" style="background-color: {{ $principalColor }}">
                        <i class="fas fa-bug me-1"></i> RELATAR BUG
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=5516981076049&text=Gostaria%20de%20falar%20sobre%20marketing%20digital"
                        target="_blank" rel="noopener" class="btn bg-white"
                        style="color: {{ $principalColor }}; border-color: {{ $principalColor }}">
                        <i class="fab fa-whatsapp me-1"></i> AJUDA WHATSAPP
                    </a>
                </div>
            </x-form.section>
        </div>
    </div>
@endsection

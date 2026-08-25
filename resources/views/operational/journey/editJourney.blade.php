@extends('layouts/master')

@section('title', 'JORNADAS')

@section('image-top')
    <i class="fa fa-coffee"></i>
@endsection

@section('description')
@endsection

@section('buttons')

    <x-buttons.list model='journey' :principalColor=$principalColor ?? null />
@endsection

@section('main')
    <form action="{{ route('journey.update', ['journey' => $journey]) }}" method="post"
        style="width: 100%; background: #fff; padding: 0px 20px;">
        <div style="width: 100%; margin-top: 30px;">
            @csrf
            @method('put')
            <div style="display: flex; flex-direction: column; gap: 18px;">
                <div>
                    <label class="labels" for="user_id">EQUIPE:</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option class='fields' value='{{ $journey->user_id }}'>
                            {{ $journey->user->contact->name }}
                        </option>
                        @foreach ($users as $user)
                            <option class='fields' value='{{ $user->id }}'>
                                {{ $user->contact->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="flex: 1;">
                        <label class="labels" for="task_id">TAREFA:</label>
                        <select name="task_id" id="task_id" class="form-control">
                            <option value='{{ $journey->task->id }}'>{{ $journey->task->name }}</option>
                            @foreach ($tasks as $task)
                                <option class='fields' value='{{ $task->id }}'>
                                    {{ $task->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <a class='circular-button secondary' href='{{ route('task.create') }}' target='blank'
                        title="Nova tarefa">
                        <i class='fas fa-plus'></i>
                    </a>
                </div>
                <div>
                    <label class="labels" for="description">OBSERVAÇÕES:</label>
                    @if ($errors->has('description'))
                        <span class='text-danger'>{{ $errors->first('description') }}</span>
                    @endif
                    <textarea id="description" name="description" rows="6" class="form-control">{{ old('description', $journey->description) }}</textarea>
                </div>
                <script>
                    Jodit.make('textarea[name=\"description\"]', { language: 'pt_BR' });
                </script>
                <div style="display: flex; gap: 16px;">
                    <div style="flex: 1;">
                        <label class="labels" for="date">DATA:</label>
                        <input type="date" name="date" id="date" class="form-control"
                            value="{{ date('Y-m-d', strtotime($journey->start)) }}">
                        @if ($errors->has('date'))
                            <span class='text-danger'>{{ $errors->first('date') }}</span>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <label class="labels" for="start">INÍCIO:</label>
                        <input type="time" name="start" id="start" class="form-control"
                            value="{{ date('H:i', strtotime($journey->start)) }}">
                        @if ($errors->has('start'))
                            <span class='text-danger'>{{ $errors->first('start') }}</span>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <label class="labels" for="end">TÉRMINO:</label>
                        <input type="time" name="end" id="end" class="form-control"
                            value="{{ $journey->end }}">
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
                    <x-buttons.trash :object="$journey" model="journey" />
                    <x-buttons.cancel />
                    <x-buttons.save />
                </div>
            </div>
    </form>
@endsection

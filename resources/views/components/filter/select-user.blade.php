@props([
    'name' => 'user_id',
    'users' => [],
    'placeholder' => 'Todos os usuários',
])

<div class="col-auto">
    <select name="{{ $name }}" class="form-select" {{ $attributes }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ request($name) == $user->id ? 'selected' : '' }}>
                {{ $user->contact->name ?? $user->name }}
            </option>
        @endforeach
    </select>
</div>

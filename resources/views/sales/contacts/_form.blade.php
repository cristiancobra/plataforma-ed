{{--
    Campos do contato, compartilhados entre criar e editar.
    Variáveis: $contact (novo ou existente) e as listas de formOptions() do ContactController.
--}}
@php
    // <option>s de um select; $options pode ser lista simples ou valor => rótulo.
    // Um valor gravado que não está na lista (dado antigo) continua aparecendo selecionado.
    $options = function ($options, $field, $placeholder = null) use ($contact) {
        $options = array_is_list($options) ? array_combine($options, $options) : $options;
        $current = (string) old($field, $contact->$field);
        if ($current !== '' && !array_key_exists($current, $options)) {
            $options = [$current => $current] + $options;
        }
        $html = $placeholder !== null ? '<option value="">' . e($placeholder) . '</option>' : '';
        foreach ($options as $value => $label) {
            $html .= '<option value="' . e($value) . '"' . ((string) $value === $current ? ' selected' : '') . '>' . e($label) . '</option>';
        }

        return new \Illuminate\Support\HtmlString($html);
    };
    $selectedCompanies = collect(old('companies', $contact->exists ? $contact->companies->pluck('id')->all() : []))
        ->map(fn ($id) => (int) $id)
        ->all();
    // contatos antigos podem ter só o nome completo: usa-o como primeiro nome para não travar a edição
    $firstName = old('first_name', $contact->first_name ?: ($contact->last_name ? null : $contact->name));
@endphp

<x-form.section title="IDENTIFICAÇÃO" icon="fas fa-id-card">
    <div class="row">
        <div class="col-md-6">
            <label class="labels" for="first_name">PRIMEIRO NOME: <span class="text-danger">*</span></label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $firstName }}" required>
            @error('first_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="labels" for="last_name">SOBRENOME:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $contact->last_name) }}">
            @error('last_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <label class="labels" for="type">TIPO:</label>
            <select name="type" id="type" class="form-select">{{ $options($contactTypes, 'type', '') }}</select>
        </div>
        <div class="col-md-4">
            <label class="labels" for="status">SITUAÇÃO:</label>
            <select name="status" id="status" class="form-select">{{ $options($statuses, 'status', '') }}</select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="lead_source">ORIGEM DO CONTATO:</label>
            <select name="lead_source" id="lead_source" class="form-select">{{ $options($leadSources, 'lead_source', '') }}</select>
        </div>
    </div>
</x-form.section>

<x-form.section title="CONTATO" icon="fas fa-envelope">
    <div class="row">
        <div class="col-md-5">
            <label class="labels" for="email">EMAIL:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $contact->email) }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3">
            <label class="labels" for="phone">TELEFONE:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $contact->phone) }}">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="site">SITE:</label>
            <input type="text" name="site" id="site" class="form-control" placeholder="https://" value="{{ old('site', $contact->site) }}">
        </div>
    </div>
    <div class="row mt-3">
        @foreach (['instagram' => 'INSTAGRAM', 'facebook' => 'FACEBOOK', 'linkedin' => 'LINKEDIN', 'twitter' => 'TWITTER'] as $field => $label)
            <div class="col-md-3">
                <label class="labels" for="{{ $field }}">{{ $label }}:</label>
                <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" value="{{ old($field, $contact->$field) }}">
            </div>
        @endforeach
    </div>
</x-form.section>

<x-form.section title="PROFISSIONAL" icon="fas fa-briefcase">
    <div class="row">
        <div class="col-md-6">
            <label class="labels" for="companies">ORGANIZAÇÕES:</label>
            <select name="companies[]" id="companies" class="form-select" multiple size="6">
                @foreach ($companies as $id => $name)
                    <option value="{{ $id }}" @selected(in_array($id, $selectedCompanies))>{{ $name }}</option>
                @endforeach
            </select>
            <div class="form-text">Segure Ctrl (ou Cmd) para selecionar mais de uma.</div>
        </div>
        <div class="col-md-6">
            <label class="labels" for="job_position">CARGO:</label>
            <input type="text" name="job_position" id="job_position" class="form-control"
                value="{{ old('job_position', $contact->job_position) }}">
            <label class="labels mt-3" for="profession">PROFISSÃO:</label>
            <select name="profession" id="profession" class="form-select">{{ $options($professions, 'profession', '') }}</select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label class="labels" for="schollarity">ESCOLARIDADE:</label>
            <select name="schollarity" id="schollarity" class="form-select">{{ $options($schollarities, 'schollarity', '') }}</select>
        </div>
        <div class="col-md-6">
            <label class="labels" for="usp_id">NÚMERO USP:</label>
            <input type="text" name="usp_id" id="usp_id" class="form-control" maxlength="8" value="{{ old('usp_id', $contact->usp_id) }}">
            @error('usp_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row g-3 mt-0">
        @foreach (range(1, 5) as $i)
            <div class="col-md-4">
                <label class="labels" for="area_of_knowledge_{{ $i }}">ÁREA DO CONHECIMENTO {{ $i }}:</label>
                <input type="text" name="area_of_knowledge_{{ $i }}" id="area_of_knowledge_{{ $i }}" class="form-control"
                    value="{{ old("area_of_knowledge_$i", $contact->{"area_of_knowledge_$i"}) }}">
            </div>
        @endforeach
    </div>
</x-form.section>

<x-form.section title="LOCALIZAÇÃO" icon="fas fa-map-marker-alt">
    <div class="row">
        <div class="col-md-8">
            <label class="labels" for="address">ENDEREÇO:</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $contact->address) }}">
        </div>
        <div class="col-md-4">
            <label class="labels" for="neighborhood">BAIRRO:</label>
            <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                value="{{ old('neighborhood', $contact->neighborhood) }}">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <label class="labels" for="zip_code">CEP:</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ old('zip_code', $contact->zip_code) }}">
        </div>
        <div class="col-md-3">
            <label class="labels" for="city">CIDADE:</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $contact->city) }}">
        </div>
        <div class="col-md-3">
            <label class="labels" for="state">ESTADO:</label>
            <select name="state" id="state" class="form-select">{{ $options($states, 'state', '') }}</select>
        </div>
        <div class="col-md-3">
            <label class="labels" for="country">PAÍS:</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $contact->country) }}">
        </div>
    </div>
</x-form.section>

<x-form.section title="PERFIL" icon="fas fa-user-circle">
    <div class="row">
        <div class="col-md-4">
            <label class="labels" for="date_birth">DATA DE NASCIMENTO:</label>
            <input type="date" name="date_birth" id="date_birth" class="form-control"
                value="{{ old('date_birth', $contact->date_birth ? substr($contact->date_birth, 0, 10) : null) }}">
            @error('date_birth')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf', $contact->cpf) }}">
            @error('cpf')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="gender">GÊNERO:</label>
            <select name="gender" id="gender" class="form-select">{{ $options($genderTypes, 'gender', '') }}</select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <label class="labels" for="civil_state">ESTADO CIVIL:</label>
            <select name="civil_state" id="civil_state" class="form-select">{{ $options($civilStates, 'civil_state', '') }}</select>
        </div>
        <div class="col-md-4">
            <label class="labels" for="naturality">NATURALIDADE:</label>
            <input type="text" name="naturality" id="naturality" class="form-control" value="{{ old('naturality', $contact->naturality) }}">
        </div>
        <div class="col-md-4">
            <label class="labels" for="kids">FILHOS:</label>
            <input type="number" min="0" step="1" name="kids" id="kids" class="form-control text-end" value="{{ old('kids', $contact->kids) }}">
            @error('kids')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <label class="labels" for="hobbie">HOBBIE PRINCIPAL:</label>
            <select name="hobbie" id="hobbie" class="form-select">{{ $options($hobbies, 'hobbie', '') }}</select>
        </div>
        <div class="col-md-3">
            <label class="labels" for="income">RENDA:</label>
            <input type="text" name="income" id="income" class="form-control" value="{{ old('income', $contact->income) }}">
        </div>
        <div class="col-md-3">
            <label class="labels" for="religion">RELIGIÃO:</label>
            <select name="religion" id="religion" class="form-select">{{ $options($religions, 'religion', '') }}</select>
        </div>
        <div class="col-md-3">
            <label class="labels" for="etinicity">ETNIA:</label>
            <select name="etinicity" id="etinicity" class="form-select">{{ $options($etinicities, 'etinicity', '') }}</select>
        </div>
    </div>
</x-form.section>

<x-form.section title="OBSERVAÇÕES" icon="fas fa-comment-dots">
    <textarea name="observations" id="observations" class="form-control" rows="4">{{ old('observations', $contact->observations) }}</textarea>
</x-form.section>

<x-form.section title="AUTORIZAÇÕES" icon="fas fa-shield-alt">
    @foreach ([
        'authorization_data' => 'Autorizo o armazenamento dos meus dados.',
        'authorization_contact' => 'Permito que a empresa entre em contato comigo.',
        'authorization_newsletter' => 'Quero receber notícias sobre a empresa e seus produtos/serviços.',
    ] as $field => $label)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1"
                @checked(old($field, $contact->$field))>
            <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
        </div>
    @endforeach
</x-form.section>

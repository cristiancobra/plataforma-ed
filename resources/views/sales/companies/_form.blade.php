{{--
    Campos da organização, compartilhados entre criar e editar.
    Variáveis: $company (nova ou existente), $contacts, $states, $types, $statuses, $sectors, $businessModelTypes.
--}}
@php
    // <option>s de um select; $options pode ser lista simples ou valor => rótulo.
    // Um valor gravado que não está na lista (dado antigo) continua aparecendo selecionado.
    $options = function ($options, $field, $placeholder = null) use ($company) {
        $options = array_is_list($options) ? array_combine($options, $options) : $options;
        $current = (string) old($field, $company->$field);
        if ($current !== '' && !array_key_exists($current, $options)) {
            $options = [$current => $current] + $options;
        }
        $html = $placeholder !== null ? '<option value="">' . e($placeholder) . '</option>' : '';
        foreach ($options as $value => $label) {
            $html .= '<option value="' . e($value) . '"' . ((string) $value === $current ? ' selected' : '') . '>' . e($label) . '</option>';
        }

        return new \Illuminate\Support\HtmlString($html);
    };
    $selectedContacts = collect(old('contacts', $company->exists ? $company->contacts->pluck('id')->all() : []))
        ->map(fn ($id) => (int) $id)
        ->all();
@endphp

<x-form.section title="IDENTIFICAÇÃO" icon="fas fa-id-card">
    <div class="row">
        <div class="col-md-8">
            <label class="labels" for="name">NOME: <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $company->name) }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="cnpj">CNPJ:</label>
            <input type="text" name="cnpj" id="cnpj" class="form-control" value="{{ old('cnpj', $company->cnpj) }}">
            @error('cnpj')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <label class="labels" for="type">TIPO:</label>
            <select name="type" id="type" class="form-select">{{ $options($types, 'type') }}</select>
        </div>
        <div class="col-md-4">
            <label class="labels" for="status">SITUAÇÃO:</label>
            <select name="status" id="status" class="form-select">{{ $options($statuses, 'status', '') }}</select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <label class="labels" for="description">DESCRIÇÃO:</label>
            <textarea name="description" id="description" class="form-control" rows="2" maxlength="255">{{ old('description', $company->description) }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</x-form.section>

<x-form.section title="SITUAÇÃO CADASTRAL (CADIN)" icon="fas fa-file-invoice-dollar"
    hint="Situação no Cadastro Informativo de créditos não quitados do setor público.">
    <div class="row">
        <div class="col-md-4">
            <label class="labels" for="cadin_estadual">CADIN ESTADUAL:</label>
            <select name="cadin_estadual" id="cadin_estadual" class="form-select">
                {{ $options(\App\Models\Company::cadinStatusOptions(), 'cadin_estadual', 'Não consultado') }}
            </select>
            @error('cadin_estadual')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="cadin_federal">CADIN FEDERAL:</label>
            <select name="cadin_federal" id="cadin_federal" class="form-select">
                {{ $options(\App\Models\Company::cadinStatusOptions(), 'cadin_federal', 'Não consultado') }}
            </select>
            @error('cadin_federal')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="cadin_checked_at">DATA DA CONSULTA:</label>
            <input type="date" name="cadin_checked_at" id="cadin_checked_at" class="form-control"
                value="{{ old('cadin_checked_at', $company->cadin_checked_at?->format('Y-m-d')) }}">
            @error('cadin_checked_at')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</x-form.section>

<x-form.section title="CONTATO" icon="fas fa-address-book">
    <div class="row">
        <div class="col-md-6">
            <label class="labels" for="email">EMAIL:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $company->email) }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label class="labels" for="financial_email">EMAIL FINANCEIRO:</label>
            <input type="email" name="financial_email" id="financial_email" class="form-control"
                value="{{ old('financial_email', $company->financial_email) }}">
            @error('financial_email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <label class="labels" for="phone">TELEFONE:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $company->phone) }}">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-8">
            <label class="labels" for="site">SITE:</label>
            <input type="url" name="site" id="site" class="form-control" placeholder="https://"
                value="{{ old('site', $company->site) }}">
            @error('site')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</x-form.section>

<x-form.section title="LOCALIZAÇÃO" icon="fas fa-map-marker-alt">
    <div class="row">
        <div class="col-md-8">
            <label class="labels" for="address">ENDEREÇO:</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $company->address) }}">
        </div>
        <div class="col-md-4">
            <label class="labels" for="neighborhood">BAIRRO:</label>
            <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                value="{{ old('neighborhood', $company->neighborhood) }}">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">
            <label class="labels" for="zip_code">CEP:</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ old('zip_code', $company->zip_code) }}">
        </div>
        <div class="col-md-3">
            <label class="labels" for="city">CIDADE:</label>
            <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $company->city) }}">
        </div>
        <div class="col-md-3">
            <label class="labels" for="state">ESTADO:</label>
            <select name="state" id="state" class="form-select">{{ $options($states, 'state', '') }}</select>
        </div>
        <div class="col-md-3">
            <label class="labels" for="country">PAÍS:</label>
            <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $company->country) }}">
        </div>
    </div>
</x-form.section>

<x-form.section title="REDES SOCIAIS" icon="fas fa-share-alt">
    <div class="row">
        @foreach (['instagram' => 'INSTAGRAM', 'facebook' => 'FACEBOOK', 'linkedin' => 'LINKEDIN', 'twitter' => 'TWITTER'] as $field => $label)
            <div class="col-md-3">
                <label class="labels" for="{{ $field }}">{{ $label }}:</label>
                <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" value="{{ old($field, $company->$field) }}">
            </div>
        @endforeach
    </div>
</x-form.section>

<x-form.section title="ÁREAS DE ATUAÇÃO" icon="fas fa-briefcase">
    <div class="row g-3">
        @foreach (range(1, 5) as $i)
            <div class="col-md-4">
                <label class="labels" for="field_of_activity_{{ $i }}">ÁREA {{ $i }}:</label>
                <input type="text" name="field_of_activity_{{ $i }}" id="field_of_activity_{{ $i }}" class="form-control"
                    value="{{ old("field_of_activity_$i", $company->{"field_of_activity_$i"}) }}">
            </div>
        @endforeach
    </div>
</x-form.section>

<x-form.section title="PERFIL" icon="fas fa-chart-line">
    <div class="row">
        <div class="col-md-4">
            <label class="labels" for="employees">QUANTIDADE DE EMPREGADOS:</label>
            <input type="number" min="0" step="1" name="employees" id="employees" class="form-control text-end"
                value="{{ old('employees', $company->employees) }}">
            @error('employees')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="client_number">QUANTIDADE DE CLIENTES:</label>
            <input type="number" min="0" step="1" name="client_number" id="client_number" class="form-control text-end"
                value="{{ old('client_number', $company->client_number) }}">
            @error('client_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <label class="labels" for="revenues">FATURAMENTO (R$):</label>
            <input type="number" min="0" step="1" name="revenues" id="revenues" class="form-control text-end"
                value="{{ old('revenues', $company->revenues) }}">
            @error('revenues')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <label class="labels" for="sector">SETOR:</label>
            <select name="sector" id="sector" class="form-select">{{ $options($sectors, 'sector', '') }}</select>
        </div>
        <div class="col-md-4">
            <label class="labels" for="business_model">MODELO DE NEGÓCIOS:</label>
            <select name="business_model" id="business_model" class="form-select">{{ $options($businessModelTypes, 'business_model', '') }}</select>
        </div>
        <div class="col-md-4">
            <label class="labels" for="competitive_advantage">DIFERENCIAL COMPETITIVO:</label>
            <input type="text" name="competitive_advantage" id="competitive_advantage" class="form-control"
                value="{{ old('competitive_advantage', $company->competitive_advantage) }}">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <label class="labels" for="value_offer">PROPOSTA DE VALOR:</label>
            <textarea name="value_offer" id="value_offer" class="form-control" rows="4">{{ old('value_offer', $company->value_offer) }}</textarea>
        </div>
    </div>
</x-form.section>

@if ($contacts->isNotEmpty())
    <x-form.section title="EQUIPE" icon="fas fa-users" hint="Contatos que trabalham nesta organização.">
        <div class="row border rounded p-2 mx-0" style="max-height: 260px; overflow-y: auto;">
            @foreach ($contacts as $contact)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="contacts[]" value="{{ $contact->id }}"
                            id="contact_{{ $contact->id }}" @checked(in_array($contact->id, $selectedContacts))>
                        <label class="form-check-label" for="contact_{{ $contact->id }}">{{ $contact->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </x-form.section>
@endif

@extends('layouts/show')

@section('title', $title)

@section('image-top')
    <i class="fa fa-bullseye"></i>
@endsection

@section('actions')
    <x-buttons.edit model="opportunity" :object="$opportunity" parameter2="department" :value2="$opportunity->department" :principalColor="$principalColor" />
@endsection

@section('buttons')
    <x-buttons.list model="opportunity" parameter="department" :value="$opportunity->department" :principalColor="$principalColor" />
@endsection

@section('trash')
    <x-buttons.trash :object="$opportunity" model="opportunity" />
@endsection

@section('name', $opportunity->name)


@section('status', $priority)


@section('status', $status)


@section('fieldsId')
    <div class='col-2 pe-0' style='text-align: center'>
        <div class='show-label'>
            ORGANIZAÇÃO
        </div>
        <div class='show-label'>
            CONTATO
        </div>
    </div>
    <div class='col-4 ps-0' style='text-align: center'>
        @if (empty($companyName))
            <div class='show-field-end'>
                Pessoa física
            </div>
        @else
            <a href='{{ route('company.show', ['company' => $opportunity->company]) }}'>
                <div class='show-field-end'>
                    {{ $companyName }}
                </div>
            </a>
        @endif

        @if ($opportunity->contact)
            <a href='{{ route('contact.show', ['contact' => $opportunity->contact]) }}'>
                <div class='show-field-end'>
                    {{ $opportunity->contact->name }}
                </div>
            </a>
        @else
            <div class='show-field-end'>
                Não possui
            </div>
        @endif

    </div>

    <div class='col-2 pe-0' style='text-align: center'>
        <div class='show-label'>
            RESPONSÁVEL
        </div>
    </div>
    <div class='col-4 ps-0' style='text-align: center'>
        @if (isset($opportunity->user->contact->name))
            <a href='{{ route('user.show', ['user' => $opportunity->user]) }}'>
                <div class='show-field-end'>
                    {{ $opportunity->user->contact->name }}
                </div>
            </a>
        @else
            <div class='show-field-end'>
                foi excluído
            </div>
        @endif
    </div>
@endsection

@section('date_start')
    <div class='circle-date-start'>
        @if ($opportunity->date_start == null)
            indefinida
        @else
            {{ date('d/m/Y', strtotime($opportunity->date_start)) }}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
@endsection


@section('date_due')
    <div class='circle-date-due'>
        @if (strtotime($opportunity->date_due) <= 0)
            indefinida
        @else
            {{ date('d/m/Y', strtotime($opportunity->date_due)) }}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        {{ $dateDue }}
    </p>
@endsection


@section('date_conclusion')
    <div class='circle-date-conclusion'>
        @if ($opportunity->date_conclusion == null)
            --
        @else
            <p style='color:white'>
                {{ date('d/m/Y', strtotime($opportunity->date_conclusion)) }}
            </p>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CONCLUSÃO
    </p>
@endsection


@section('description')
    {!! html_entity_decode($opportunity->description) !!}
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
    <x-show.section title="PROSPECÇÃO" icon="fas fa-search-dollar">
        <x-slot:actions>
            <x-buttons.icon-form method="POST" icon="fas fa-paper-plane" title="Enviar material" :action="route('task.create')" :principalColor="$principalColor">
                <input type='hidden' name='task_name' value='ENVIAR MATERIAL:'>
                <input type='hidden' name='opportunity_id' value='{{ $opportunity->id }}'>
                <input type='hidden' name='opportunity_name' value='{{ $opportunity->name }}'>
                <input type='hidden' name='company_name' value='{{ $companyName }}'>
                <input type='hidden' name='company_id' value='{{ $companyId }}'>
                @if ($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{ $opportunity->contact->name }}'>
                <input type='hidden' name='contact_id' value='{{ $opportunity->contact->id }}'>
                @endif
                <input type='hidden' name='department' value='vendas'>
            </x-buttons.icon-form>
            <x-buttons.icon-form method="POST" icon="fas fa-calendar-plus" title="Agendar reunião" :action="route('task.create')" :principalColor="$principalColor">
                <input type='hidden' name='task_name' value='AGENDAR REUNIÃO:'>
                <input type='hidden' name='opportunity_id' value='{{ $opportunity->id }}'>
                <input type='hidden' name='opportunity_name' value='{{ $opportunity->name }}'>
                <input type='hidden' name='company_name' value='{{ $companyName }}'>
                <input type='hidden' name='company_id' value='{{ $companyId }}'>
                @if ($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{ $opportunity->contact->name }}'>
                <input type='hidden' name='contact_id' value='{{ $opportunity->contact->id }}'>
                @endif
                <input type='hidden' name='department' value='vendas'>
            </x-buttons.icon-form>
        </x-slot:actions>
        @empty($companyName)
            <div class='tb-row'>
                <a href='{{ route('company.create') }}'>
                    adicionar empresa
                </a>
            </div>
        @else
        <div class='tb-row'>
            <i class='fas fa-store me-2'></i>
            <a
                href='{{ route('company.edit', [
                    'company' => $opportunity->company,
                    'typeCompanies' => 'cliente',
                ]) }}'>
                <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for=''>
                    {{ mb_strtoupper($companyName) }}
                </label>
            </a>
        </div>
        <div class='tb-row'>
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Proposta de
                valor: </label>
            @if (isset($opportunity->company->value_offer))
                {!! html_entity_decode($opportunity->company->value_offer) !!}
            @else
                --
            @endif
        </div>
        <div class='tb-row'>
            <div class='col'>
                <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Diferencial
                    competitivo: </label>
                @if (isset($opportunity->company->competitive_advantage))
                    {{ $opportunity->company->competitive_advantage }}
                @else
                    --
                @endif
            </div>
            <div class='col'>
                <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Modelo de
                    negócio: </label>
                @if (isset($opportunity->company->business_model))
                    {{ $opportunity->company->business_model }}
                @else
                    --
                @endif
            </div>
        </div>

        <div class='tb-row'>
            <div class='col'>
                <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Setor:
                </label>
                @if (isset($opportunity->company->sector))
                    {{ $opportunity->company->sector }}
                @else
                    --
                @endif
            </div>
            <div class='col'>
                <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Equipe:
                </label>
                <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for=''>
                    @if (isset($opportunity->company->employees))
                        {{ $opportunity->company->employees }}
                    @else
                        --
                    @endif
                </label>
            </div>
        </div>

        <div class='tb-row'>
            <div class='col'>
                <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Clientes:
                </label>
                @if (isset($opportunity->company->client_number))
                    {{ $opportunity->company->client_number }}
                @else
                    --
                @endif
            </div>
            <div class='col'>
                <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>Faturamento:
                </label>
                @if (isset($opportunity->company->revenues))
                    {{ $opportunity->company->revenues }}
                @else
                    --
                @endif
            </div>
        </div>
    @endempty


    <div class='tb-row pt-5'>
        <i class='fas fa-users me-2'></i>
        @if ($opportunity->contact)
            <a href='{{ route('contact.show', ['contact' => $opportunity->contact]) }}'>
                <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for=''>
                    {{ mb_strtoupper($opportunity->contact->name) }}
                </label>
            </a>
        @else
            <a href='{{ route('contact.create') }}'>
                adicionar
            </a>
        @endif
    </div>
    <div class='tb-row'>
        <div class='col'>
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>
                Email:
            </label>
            @if ($opportunity->contact && $opportunity->contact->email)
                {{ $opportunity->contact->email }}
            @else
                --
            @endif
        </div>
        <div class='col'>
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for=''>
                Telefone:
            </label>
            @if ($opportunity->contact)
                {{ $opportunity->contact->phone }}
            @else
                --
            @endif
        </div>
    </div>
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'CRIAÇÃO', 'class' => 'col-2'],
        ['label' => 'TAREFA', 'class' => 'col-3'],
        ['label' => 'DESCRIÇÃO', 'class' => 'col-4'],
        ['label' => 'CONCLUSÃO', 'class' => 'col-1'],
        ['label' => 'PRIORIDADE', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($tasksSales as $task)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('task.show', ['task' => $task->id]) }}">
            <div class="col-2 small">{{ dateBr($task->date_start) }}</div>
            <div class="col-3 fw-bold small">{{ $task->name }}</div>
            <div class="col-4 small">{!! html_entity_decode($task->description) !!}</div>
            <div class="col-1 small">
                @if ($task->date_conclusion)
                    {{ dateBr($task->date_conclusion) }}
                @else
                    em aberto
                @endif
            </div>
            <div class="col-1 text-center"><x-table.status :value="$task->priority" /></div>
            <div class="col-1 text-center">
                @if ($task->status == 'fazer' && $task->journeys()->exists())
                    <x-table.status value="fazendo" />
                @elseif ($task->status == 'fazer' && $task->date_due <= date('Y-m-d'))
                    <x-table.status value="atrasada" />
                @else
                    <x-table.status :value="$task->status" />
                @endif
            </div>
        </div>
    @endforeach
    <div class="row border-top pt-2 mt-2">
        <div class="col text-end fw-bold small">TOTAL: {{ formatTotalHour($tasksSalesHours) }} horas</div>
    </div>
    </x-show.section>

    <x-show.section title="PROPOSTAS" icon="fa fa-receipt" id="proposals">
        <x-slot:actions>
            @if ($proposalWon == 0)
                <x-buttons.create model="proposal" :params="['type' => 'receita', 'opportunity' => $opportunity]" :principalColor="$principalColor ?? null" />
            @else
                <x-show.badge icon="fa fa-check" label="Proposta ganha" :colors="['#E8F5E9', '#2E7D32']" />
            @endif
        </x-slot:actions>
        <x-table.header :background-color="$principalColor" :columns="[
            ['label' => 'ID', 'class' => 'col-1'],
            ['label' => 'NOME', 'class' => 'col-4'],
            ['label' => 'CRIAÇÃO', 'class' => 'col-1'],
            ['label' => 'VENCIMENTO', 'class' => 'col-1'],
            ['label' => 'RECEBER', 'class' => 'col-2'],
            ['label' => 'VALOR', 'class' => 'col-2'],
            ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ]" />
        @foreach ($proposals as $proposal)
            <div class='row row-link border-bottom py-2 align-items-center' data-href="{{ route('proposal.show', ['proposal' => $proposal->id]) }}">
                <div class='col-1 small'>{{ $proposal->identifier }}</div>
                <div class='col-4 fw-bold small'>{{ $proposal->name }}</div>
                <div class='col-1 text-center small'>{{ dateBr($proposal->date_creation) }}</div>
                <div class='col-1 text-center small'>{{ dateBr($proposal->pay_day) }}</div>
                <div class='col-2 text-end small'>{{ formatCurrencyReal($proposal->balance) }}</div>
                <div class='col-2 text-end small'>{{ formatCurrencyReal($proposal->totalPrice) }}</div>
                <div class='col-1 text-center'><x-table.status :value="$proposal->status" /></div>
            </div>
        @endforeach
    </x-show.section>




    <x-sections.invoices :proposal='$proposalApproved' />


    <x-show.section title="CONTRATOS" icon="fas fa-file-signature">
        <x-slot:actions>
            <x-buttons.icon-form method="POST" icon="fas fa-file-signature" title="Fazer contrato" :action="route('task.create')" :principalColor="$principalColor">
                <input type='hidden' name='task_name' value='CONTRATO:'>
                <input type='hidden' name='opportunity_id' value='{{ $opportunity->id }}'>
                <input type='hidden' name='opportunity_name' value='{{ $opportunity->name }}'>
                <input type='hidden' name='company_name' value='{{ $companyName }}'>
                <input type='hidden' name='company_id' value='{{ $companyId }}'>
                @if ($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{ $opportunity->contact->name }}'>
                <input type='hidden' name='contact_id' value='{{ $opportunity->contact->id }}'>
                @endif
                <input type='hidden' name='account_name' value='{{ $opportunity->account->name }}'>
                <input type='hidden' name='account_id' value='{{ $opportunity->account->id }}'>
                <input type='hidden' name='department' value='vendas'>
            </x-buttons.icon-form>
            <x-buttons.icon-form method="POST" icon="fas fa-file-contract" title="Gerar contrato" :action="route('contract.create')" :principalColor="$principalColor">
                <input type='hidden' name='opportunity_id' value='{{ $opportunity->id }}'>
                <input type='hidden' name='opportunity_name' value='{{ $opportunity->name }}'>
                <input type='hidden' name='opportunity_description' value='{{ $opportunity->description }}'>
                @if ($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{ $opportunity->contact->name }}'>
                <input type='hidden' name='contact_id' value='{{ $opportunity->contact->id }}'>
                @endif
                <input type='hidden' name='account_name' value='{{ $opportunity->account->name }}'>
                <input type='hidden' name='account_id' value='{{ $opportunity->account->id }}'>
                <input type='hidden' name='company_names' value='{{ $contactCompanies }}'>
                <input type='hidden' name='company_ids' value='{{ $contactCompanies }}'>
                <input type='hidden' name='department' value='vendas'>
                <input type='hidden' name='status' value='pendente'>
            </x-buttons.icon-form>
        </x-slot:actions>
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'ID', 'class' => 'col-1'],
        ['label' => 'TÍTULO', 'class' => 'col-2'],
        ['label' => 'CONTRATADA', 'class' => 'col-2'],
        ['label' => 'CONTRATANTE', 'class' => 'col-2'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-2'],
        ['label' => 'INÍCIO', 'class' => 'col-1'],
        ['label' => 'VENCIMENTO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($contracts as $contract)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('contract.show', ['contract' => $contract->id]) }}">
            <div class="col-1 small">{{ $contract->identifier }}</div>
            <div class="col-2 fw-bold small">{{ $contract->name }}</div>
            <div class="col-2 small">{{ $contract->account->name }}</div>
            <div class="col-2 small">{{ $contract->company->name }}</div>
            <div class="col-2 small">{{ $contract->contact->name }}</div>
            <div class="col-1 small">{{ dateBr($contract->date_start) }}</div>
            <div class="col-1 small">{{ dateBr($contract->date_due) }}</div>
            <div class="col-1 text-center"><x-table.status :value="$contract->status" /></div>
        </div>
    @endforeach
    </x-show.section>

    <x-show.section title="PRODUÇÃO" icon="fas fa-industry">
        <x-slot:actions>
            <x-buttons.icon-form method="POST" icon="fas fa-hammer" title="Solicitar produção" :action="route('task.create')" :principalColor="$principalColor">
                <input type='hidden' name='task_name' value='PRODUZIR:'>
                <input type='hidden' name='opportunity_id' value='{{ $opportunity->id }}'>
                <input type='hidden' name='opportunity_name' value='{{ $opportunity->name }}'>
                <input type='hidden' name='department' value='produção'>
            </x-buttons.icon-form>
            <x-buttons.icon-form method="POST" icon="fas fa-truck" title="Realizar entrega" :action="route('task.create')" :principalColor="$principalColor">
                <input type='hidden' name='task_name' value='ENTREGAR:'>
                <input type='hidden' name='opportunity_id' value='{{ $opportunity->id }}'>
                <input type='hidden' name='opportunity_name' value='{{ $opportunity->name }}'>
                @if ($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{ $opportunity->contact->name }}'>
                <input type='hidden' name='contact_id' value='{{ $opportunity->contact->id }}'>
                @endif
                <input type='hidden' name='department' value='produção'>
            </x-buttons.icon-form>
            <x-buttons.icon icon="fa fa-file-pdf" title="Relatório em PDF" :href="route('opportunity.pdfProduction', ['opportunity' => $opportunity])" :principalColor="$principalColor" />
        </x-slot:actions>
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'CRIAÇÃO', 'class' => 'col-2'],
        ['label' => 'TAREFA', 'class' => 'col-3'],
        ['label' => 'DESCRIÇÃO', 'class' => 'col-4'],
        ['label' => 'PRAZO', 'class' => 'col-1'],
        ['label' => 'PRIORIDADE', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($tasksOperational as $task)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('task.show', ['task' => $task->id]) }}">
            <div class="col-2 small">{{ dateBr($task->date_start) }}</div>
            <div class="col-3 fw-bold small">{{ $task->name }}</div>
            <div class="col-4 small">{!! html_entity_decode($task->description) !!}</div>
            <div class="col-1 small">
                @if ($task->date_due == date('Y-m-d'))
                    hoje
                @elseif ($task->date_due < date('Y-m-d'))
                    <span class="text-danger">{{ dateBr($task->date_due) }}</span>
                @else
                    {{ dateBr($task->date_due) }}
                @endif
            </div>
            <div class="col-1 text-center"><x-table.status :value="$task->priority" /></div>
            <div class="col-1 text-center"><x-table.status :value="$task->status" /></div>
        </div>
    @endforeach
    <div class="row border-top pt-2 mt-2">
        <div class="col text-end fw-bold small">TOTAL: {{ formatTotalHour($tasksOperationalHours) }} horas</div>
    </div>
    </x-show.section>

    <x-show.section title="ATENDIMENTO" icon="fas fa-headset">
        <x-slot:actions>
            <x-buttons.create model="task" title="Nova tarefa" :params="['opportunity' => $opportunity]" :principalColor="$principalColor ?? null" />
        </x-slot:actions>
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'CRIAÇÃO', 'class' => 'col-1'],
        ['label' => 'TAREFA', 'class' => 'col-2'],
        ['label' => 'DESCRIÇÃO', 'class' => 'col-4'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-2'],
        ['label' => 'CONCLUSÃO', 'class' => 'col-1'],
        ['label' => 'PRIORIDADE', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
    ]" />
    @foreach ($tasksCustomerServices as $task)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('task.show', ['task' => $task->id]) }}">
            <div class="col-1 small">{{ dateBr($task->date_start) }}</div>
            <div class="col-2 fw-bold small">{{ $task->name }}</div>
            <div class="col-4 small">{!! html_entity_decode($task->description) !!}</div>
            <div class="col-2 text-center">
                <x-user.avatar :user="$task->user" :principal-color="$principalColor" />
            </div>
            <div class="col-1 small">
                @if ($task->date_conclusion)
                    {{ dateBr($task->date_conclusion) }}
                @else
                    em aberto
                @endif
            </div>
            <div class="col-1 text-center"><x-table.status :value="$task->priority" /></div>
            <div class="col-1 text-center"><x-table.status :value="$task->status" /></div>
        </div>
    @endforeach
    <div class="row border-top pt-2 mt-2">
        <div class="col text-end fw-bold small">TOTAL: {{ formatTotalHour($tasksCustomerServicesHours) }} horas</div>
    </div>
    </x-show.section>
@endsection

@section('deleteButton')
    <x-buttons.trash :object="$opportunity" model="opportunity" />
@endsection

@section('editButton', route('opportunity.edit', ['opportunity' => $opportunity->id]))

@section('backButton', route('opportunity.index'))

@section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{ date('d/m/Y H:i', strtotime($opportunity->created_at)) }}
        </div>
    </div>
@endsection



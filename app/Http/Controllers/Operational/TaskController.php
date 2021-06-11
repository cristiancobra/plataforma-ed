<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use DB;
use PDF;

class TaskController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
//        dd($request);
        $today = date('Y-m-d');
        $tasks = $this->filterTasks($request);
//dd($tasks);
        $teamTasksPending = Task::where('account_id', Auth::user()->account_id)
                ->where('status', 'fazer')
                ->where('priority', 'emergência')
                ->get();

        $teamTasksPendingAmount = $teamTasksPending->where('account_id', Auth::user()->account_id)
                ->count();

        $myTasksPendingAmount = $teamTasksPending->where('user_id', Auth::user()->id)
                ->count();

//            $myTasksPending = Task::where('user_id', Auth::user()->id)
//                    ->where('status', 'fazer')
//                    ->where('priority', 'emergência')
//                    ->count();

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = myUsers();
        $status = $this->returnStatus();
        $departments = Task::returnDepartments();
        $priorities = Task::returnPriorities();

        return view('operational.tasks.indexTasks', compact(
                        'tasks',
                        'teamTasksPendingAmount',
                        'myTasksPendingAmount',
                        'contacts',
                        'companies',
                        'users',
                        'today',
                        'status',
                        'departments',
                        'priorities',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $contacts = Contact::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = myUsers();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $opportunities = $this->accountOpportunities('create');

        $today = date("Y-m-d");
        $departments = returnDepartments();
        $status = $this->returnStatus();
        $priorities = returnPriorities();

        // campos enviados por request
        $taskName = $request->task_name;
        $opportunityId = $request->opportunity_id;
        $opportunityName = $request->opportunity_name;
        $opportunityContactName = $request->contact_name;
        $opportunityContactId = $request->contact_id;
        $taskAccountName = $request->account_name;
        $taskAccountId = $request->account_id;
        $department = 'vendas';

        return view('operational.tasks.createTask', compact(
                        'users',
                        'contacts',
                        'companies',
                        'taskName',
                        'today',
                        'departments',
                        'status',
                        'priorities',
                        'taskName',
                        'opportunityId',
                        'opportunityName',
                        'opportunityContactName',
                        'opportunityContactId',
                        'taskAccountName',
                        'taskAccountId',
                        'department',
                        'opportunities',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:tasks',
                    'date_start' => 'required:tasks',
                    'date_due' => 'required:tasks',
                    'description' => 'required:tasks',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $task = new Task();
            $task->fill($request->all());
            $task->account_id = auth()->user()->account_id;
            $task->status = 'fazer';
            $task->save();

            $journeys = Journey::where('task_id', $task->id)
                    ->get();

            return redirect()->route('task.show', [$task]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tasks  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task) {
        $today = date('Y-m-d');

        $totalDuration = 0;
        foreach ($task->journeys as $journey) {
            $totalDuration = $totalDuration + $journey->duration;
        }

        return view('operational.tasks.showTask', compact(
                        'today',
                        'task',
                        'totalDuration',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tasks  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(task $task) {
        $contacts = Contact::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->orderBy('NAME', 'ASC')
                ->get();

        $tasks = Task::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->with('contact')
                ->paginate(20);

        $users = User::whereHas('accounts', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->get();

        $opportunities = $this->accountOpportunities('edit');

        $departments = Task::returnDepartments();
        $status = $this->returnStatus();
        $priorities = Task::returnPriorities();

        return view('operational.tasks.editTask', compact(
                        'task',
                        'tasks',
                        'users',
                        'opportunities',
                        'contacts',
                        'companies',
                        'departments',
                        'status',
                        'priorities',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tasks  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, task $task) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:tasks',
                    'date_start' => 'required:tasks',
                    'date_due' => 'required:tasks',
                    'description' => 'required:tasks',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $task->fill($request->all());
            if (isset($request->cancelado)) {
                $task->status = 'cancelado';
                $task->date_conclusion = "";
            } elseif (isset($request->aguardar)) {
                $task->status = 'aguardar';
                $task->date_conclusion = "";
            } elseif (isset($request->date_conclusion)) {
                $task->status = 'feito';
            } else {
                $task->status = 'fazer';
            }

            $task->save();

            return redirect()->route('task.show', [$task]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tasks  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(task $task) {
        $task->delete();
        return redirect()->action('Operational\\TaskController@index');
    }

    public function accountOpportunities($method) {
        switch ($method) {
            case 'create':
                $accountOpportunities = Opportunity::whereIn('account_id', userAccounts())
                        ->where('stage', '!=', 'perdemos')
                        ->where('stage', '!=', 'concluída')
                        ->orderBy('date_conclusion', 'DESC')
                        ->get();
                break;
            case 'edit':
                $accountOpportunities = Opportunity::whereIn('account_id', userAccounts())
                        ->where('stage', '!=', 'perdemos')
                        ->orderBy('date_conclusion', 'DESC')
                        ->get();
                break;
        }
        return $accountOpportunities;
    }

    public function duration(start_time $start_time, end_time $end_time) {
        $this->$end_time->subHour(1);
        return $this;
    }

    function returnStatus() {
        return $status = array(
            'fazer',
            'aguardar',
            'feito',
            'fazendo',
            'cancelado',
        );
    }

    public function filterTasks(Request $request) {
        $today = date('Y-m-d');
//dd($request);
        
        $tasks = Task::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->department) {
                        $query->where('department', $request->department);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->priority) {
                        $query->where('priority', $request->priority);
                    }
                    if ($request->status == '') {
                        // busca todos
//                    } elseif ($request->status == 'fazer') {
//                        $query->where('status', 'fazer');
//                        $query->doesntHave('journeys');
                    } elseif ($request->status == 'fazendo') {
                        $query->where('status', 'fazer');
                        $query->whereHas('journeys');
                    } elseif ($request->status) {
                        $query->where('status', $request->status);
//                    } else {
//                        $query->where('status', 'fazer');
                    }
                })
                ->with(
                        'opportunity',
                        'journeys',
                        'user.contact',
                )
//                ->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelada', 'feito')"))
//                ->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
                ->orderBy('date_due', 'DESC')
                ->paginate(20);
//dd($tasks);
        $tasks->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);
//dd($tasks);
        return $tasks;
    }

// Gera PDF da fatura
    public function createPDF(Task $task) {
        $journeys = Journey::where('task_id', $task->id)
//                ->with('product', 'opportunity')
                ->get();

        $totalDuration = 0;
        foreach ($task->journeys as $journey) {
            $totalDuration = $totalDuration + $journey->duration;
        }

        $bankAccounts = BankAccount::whereHas('account', function ($query) {
                    $query->whereIn('id', userAccounts());
                })
                ->where('status', 'LIKE', 'recebendo')
                ->with([
                    'account',
                    'bank',
                ])
                ->get();

        if ($task->company_id) {
            $email = $task->company->email;
            $phone = $task->company->phone;
            $address = $task->company->address;
            $city = $task->company->city;
            $state = $task->company->state;
            $country = $task->company->country;
            $companyName = $task->company->name;
            $companyCnpj = $task->company->cnpj;
        } else {
            $email = $task->contact->email;
            $phone = $task->contact->phone;
            $address = $task->contact->address;
            $city = $task->contact->city;
            $state = $task->contact->state;
            $country = $task->contact->country;
            $companyName = null;
            $companyCnpj = null;
        }

        $data = [
            'accountLogo' => $task->account->logo,
            'accountPrincipalColor' => $task->account->principal_color,
            'accountName' => $task->account->name,
            'accountEmail' => $task->account->email,
            'accountPhone' => $task->account->phone,
            'accountAddress' => $task->account->address,
            'accountCity' => $task->account->city,
            'accountState' => $task->account->state,
            'accountCnpj' => $task->account->cnpj,
            'bankAccounts' => $bankAccounts,
            'taskIdentifier' => $task->id,
            'taskName' => $task->name,
//            'invoiceDescription' => $invoice->description,
//            'invoiceDiscount' => $invoice->discount,
//            'invoiceInstallmentValue' => $invoice->installment_value,
//            'invoiceNumberInstallmentTotal' => $invoice->number_installment_total,
//            'invoiceTotalPrice' => $invoice->totalPrice,
//            'invoiceDiscount' => $invoice->discount,
            'taskDateStart' => $task->date_start,
            'taskDateDue' => $task->date_due,
//            'invoiceTotalPrice' => $invoice->totalPrice,
            'taskTotalDuration' => $totalDuration,
            'taskDescription' => $task->description,
            'customerName' => $task->contact->name,
            'companyName' => $companyName,
            'companyCnpj' => $companyCnpj,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'journeys' => $journeys,
////			'deadline' => $deadline,
        ];

        $pdf = PDF::loadView('operational.tasks.createPdf', compact('data'));
        $pdf->setPaper('A4', 'portrait');

// download PDF file with download method
        return $pdf->stream('Relatório de execução.pdf');
    }

}

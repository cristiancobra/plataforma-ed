<?php

namespace App\Http\Controllers\Tasks;

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
        $today = date('Y-m-d');

        $tasks = Task::where(function ($query) use ($request) {
                    $query->whereIn('account_id', userAccounts());
                    $query->where('user_id', auth()->user()->id);
                    $query->where('status', 'fazer');
                })
                ->with(
                        'opportunity',
                        'journeys',
                        'user.contact',
                )
//				->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelado')"))
                ->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
                ->orderBy('date_due', 'ASC')
                ->paginate(20);

        $tasks->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $users = myUsers();

        return view('tasks.indexTasks', compact(
                        'tasks',
                        'contacts',
                        'companies',
                        'accounts',
                        'users',
                        'today',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $accounts = Account::whereHas('users', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->get();

        $contacts = Contact::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = myUsers();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();
        
         $opportunities = $this->accountOpportunities();

        $today = date("Y-m-d");
        $departments = returnDepartments();
        $status = returnStatus();
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

        return view('tasks.createTask', compact(
                        'users',
                        'accounts',
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

        return view('tasks.showTask', compact(
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
        $accounts = Account::whereHas('users', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->get();

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
                
         $opportunities = $this->accountOpportunities();

        $departments = returnDepartments();
        $status = returnStatus();
        $priorities = returnPriorities();

        return view('tasks.editTask', compact(
                        'task',
                        'tasks',
                        'users',
                        'opportunities',
                        'accounts',
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
        return redirect()->action('Tasks\\TaskController@index');
    }

    public function accountOpportunities() {
        $accountOpportunities = Opportunity::whereIn('account_id', userAccounts())
                ->where('stage', '!=', 'perdemos')
                ->orderBy('date_conclusion', 'ASC')
                ->get();
        
        return $accountOpportunities;
    }

    public function duration(start_time $start_time, end_time $end_time) {
        $this->$end_time->subHour(1);
        return $this;
    }

    public function filter(Request $request) {
        $today = date('Y-m-d');

        $tasks = Task::where(function ($query) use ($request) {
                    if ($request->account_id) {
                        $query->where('account_id', '=', $request->account_id);
                    } else {
                        $query->whereIn('account_id', userAccounts());
                    }
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->user_id) {
                        $query->where('user_id', $request->user_id);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', '=', $request->company_id);
                    }
                    if ($request->status) {
                        $query->where('status', $request->status);
                    }
                })
                ->with(
                        'opportunity',
                        'journeys',
                        'user.contact',
                )
                ->orderByRaw(DB::raw("FIELD(priority, 'emergência', 'alta', 'média', 'baixa')"))
                ->orderBy('date_due', 'ASC')
                ->paginate(20);

        $tasks->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        $contacts = Contact::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->get();

        $accounts = Account::whereIn('id', userAccounts())
                ->orderBy('ID', 'ASC')
                ->get();

        $users = myUsers();

        return view('tasks.indexTasks', compact(
                        'tasks',
                        'contacts',
                        'companies',
                        'accounts',
                        'users',
                        'today',
        ));
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

        $pdf = PDF::loadView('tasks.createPdf', compact('data'));
        $pdf->setPaper('A4', 'portrait');

// download PDF file with download method
        return $pdf->stream('Relatório de execução.pdf');
    }

}

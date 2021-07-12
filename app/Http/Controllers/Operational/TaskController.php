<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Image;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;
use DateTime;

class TaskController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $today = date('Y-m-d');
        $tasks = $this->filterTasks($request);

        $teamTasksPending = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->get();

        $teamTasksEmergencyAmount = $teamTasksPending->where('account_id', auth()->user()->account_id)
                ->where('priority', 'emergência')
                ->count();

        $myTasksPendingAmount = $teamTasksPending->where('user_id', auth()->user()->id)
                ->count();

        $myTasksEmergencyAmount = $teamTasksPending->where('user_id', auth()->user()->id)
                ->where('priority', 'emergência')
                ->count();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();
        $status = $this->returnStatus();
        $departments = Task::returnDepartments();
        $priorities = Task::returnPriorities();

        return view('operational.tasks.indexTasks', compact(
                        'tasks',
                        'teamTasksEmergencyAmount',
                        'myTasksPendingAmount',
                        'myTasksEmergencyAmount',
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
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $opportunities = $this->accountOpportunities('create');

        $today = date("Y-m-d");
        $departments = Task::returnDepartments();
        $status = $this->returnStatus();
        $priorities = Task::returnPriorities();

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

            if ($request->file('image')) {
                $image = new Image();
                $image->account_id = auth()->user()->account_id;
                $image->task_id = $task->id;
                $image->type = 'tarefa';
                $image->name = 'Imagem da tarefa ' . $task->id;
                $image->status = 'disponível';
                $path = $request->file('image')->store('users_images');
                $image->path = $path;
                $image->save();
            }

//            $journeys = Journey::where('task_id', $task->id)
//                    ->get();

            return redirect()->route('task.show', [$task]);
        }
    }

    /**
      Store específico para salvar tarefas do tipo BUG
     */
    public function storeBug(Request $request) {
        $task = new Task();
        $task->account_id = 1;
        $task->user_id = 7;
        $task->date_start = date('Y-m-d');
        $task->department = 'desenvolvimento';
        $task->contact_id = auth()->user()->contact_id;
        $task->account_id = auth()->user()->account->id;
        $task->priority = $request->priority;
        $task->status = 'fazer';
        $task->type = 'bug';
        $task->name = "BUG: $request->module de " . $task->contact->name;
        $task->description = $task->contact->name . " encontrou um problema em " . mb_strtoupper($request->module, 'UTF-8') . " quando estava " . mb_strtoupper($request->action, 'UTF-8') . "<br><br> Ele adicionou: " . mb_strtoupper($request->description, 'UTF-8');

        $DateTime = new DateTime($request->date_start);
        $DateTime->add(new \DateInterval("P1D"));
        $task->date_due = $DateTime->format('Y-m-d');

        $task->save();

        if ($request->file('image')) {
            $image = new Image();
            $image->account_id = 1;
            $image->task_id = $task->id;
            $image->type = 'bug';
            $image->name = 'bug report - tarefa ' . $task->id;
            $image->status = 'disponível';
            $path = $request->file('image')->store('bugs_images');
            $image->path = $path;
            $image->save();
        }

        $journeys = Journey::where('task_id', $task->id)
                ->get();

//        return redirect()->route('task.bug', ['message' => 'Obrigado, por relatar um problema. Já encaminhamos para o responsável técnico']);
        return redirect()->back()->with('message', 'Obrigado por reportar seu problema. Já estamos encaminhando as informações para o técnico responsável!');
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
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

//        $tasks = Task::whereHas('account', function ($query) {
//                    $query->where('account_id', auth()->user()->account_id);
//                })
//                ->with('contact')
//                ->paginate(20);

        $users = User::myUsers();

        $opportunities = $this->accountOpportunities('edit');

        $departments = Task::returnDepartments();
        $status = $this->returnStatus();
        $priorities = Task::returnPriorities();

        return view('operational.tasks.editTask', compact(
                        'task',
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
                $accountOpportunities = Opportunity::where('account_id', auth()->user()->account_id)
                        ->where('stage', '!=', 'perdemos')
                        ->where('stage', '!=', 'concluída')
                        ->orderBy('date_conclusion', 'DESC')
                        ->get();
                break;
            case 'edit':
                $accountOpportunities = Opportunity::where('account_id', auth()->user()->account_id)
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
                    if ($request->type) {
                        $query->where('type', $request->type);
                    }
                    if ($request->status == '') {
                        // busca todos
                    } elseif ($request->status == 'fazendo') {
                        $query->where('status', 'fazer');
                        $query->whereHas('journeys');
                    } elseif ($request->status) {
                        $query->where('status', $request->status);
                    }
                })
                ->with(
                        'opportunity',
                        'journeys',
                        'user.contact',
                        'user.image',
                        'images',
                )
//                ->orderByRaw(DB::raw("FIELD(status, 'fazer', 'aguardar', 'cancelada', 'feito')"))
                ->orderBy('date_due', 'DESC')
                ->paginate(20);

        $tasks->appends([
            'name' => $request->name,
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

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

        $bankAccounts = BankAccount::where('id', auth()->user()->account_id)
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

    public function createBug() {
        $priorities = Task::returnPriorities();
        $modules = Task::returnBugModules();
        $actions = Task::returnBugActions();

        return view('operational.tasks.createBug', compact(
                        'priorities',
                        'modules',
                        'actions',
        ));
    }

}

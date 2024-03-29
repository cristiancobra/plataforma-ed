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
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
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
        $tasks = Task::filterTasks($request);

        foreach ($tasks as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            }
        }

        $teamTasksPending = Task::where('account_id', auth()->user()->account_id)
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
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
        $status = Task::returnStatus();
        $departments = Task::returnDepartments();
        $priorities = Task::returnPriorities();

        $trashStatus = request()->trash;

        return view('operational.tasks.index', compact(
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
                        'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if($request->contact) {
            $contact = Contact::find($request->contact);
        }else{
            $contact = null;
        }

        if($request->name) {
            $name= $request->name;
        }else{
            $name = null;
        }

        if($request->department) {
            $department= $request->department;
        }else{
            $department = null;
        }
        
        if ($request->department == 'desenvolvimento') {
            $opportunities = Opportunity::openOpportunitiesDevelopment();
        } else {
            $opportunities = Opportunity::openOpportunities();
        }

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $today = date("Y-m-d");
        $departments = Task::returnDepartments();
        $status = Task::returnStatus();
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
        
        $dateDue = new DateTime('now');
        $dateDue = $dateDue->add(new \DateInterval('P5D')); 
        $dateDue = $dateDue->format('Y-m-d'); 

        return view('operational.tasks.create', compact(
                        'users',
                        'name',
                        'department',
                        'contact',
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
                        'dateDue',
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
            $dateStart = new DateTime($request->date_due . " " . $request->time_due);
            $task->date_due = $dateStart->format('Y-m-d H:i:s');
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

            $journeys = Journey::where('task_id', $task->id)
                    ->get();

//            return redirect()->back();
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
        $task->company_id = 7;
        $task->priority = $request->priority;
        $task->status = 'fazer';
        $task->type = 'bug';
        $task->name = "BUG: $request->module de " . $task->contact->name;
        $task->description = $task->contact->name . " encontrou um problema em " . mb_strtoupper($request->module, 'UTF-8') . " quando estava " . mb_strtoupper($request->action, 'UTF-8') . "<br><br> Ele adicionou: " . html_entity_decode($request->description);

        $DateTime = new DateTime($request->date_start);
        $DateTime->add(new \DateInterval("P1D"));
        $task->date_due = $DateTime->format('Y-m-d');

//        $authEmail = auth()->user()->email;
//        $authContact = Contact::where('email', $authEmail)
//                ->where('account_id', 1)
//                ->first();
//        $authCompany = Company::whereHas('contacts', function($query) use($authContact) {
//            $query->where('contacts.id', $authContact->id);
//        })
//                ->first();
//        $task->company_id = $authCompany->id;

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
        if ($task->status == 'fazer' AND $task->journeys()->exists()) {
            $task->status = 'fazendo';
        }
        
        $status = $task->status;
        $priority= $task->priority;

        $openJourney = Journey::myOpenJourney();

        return view('operational.tasks.show', compact(
                        'today',
                        'task',
                        'totalDuration',
                        'status',
                        'priority',
                        'openJourney',
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

        $users = User::myUsers();

        $opportunities = Opportunity::openOpportunities();
        $projects = Project::getProjects();

        $departments = Task::returnDepartments();
//        $stages = Task::returnStages();
        $status = Task::returnStatus();
        $priorities = Task::returnPriorities();
        $taskStages = Task::returnTaskStages($task);

        return view('operational.tasks.edit', compact(
                        'task',
                        'users',
                        'opportunities',
                        'projects',
                        'contacts',
                        'companies',
                        'departments',
                        'status',
                        'priorities',
                        'taskStages',
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
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $task->fill($request->all());
            $dateDue = new DateTime($request->date_due . " " . $request->time_due);
            $task->date_due = $dateDue->format('Y-m-d H:i:s');

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

    public function duration(start_time $start_time, end_time $end_time) {
        $this->$end_time->subHour(1);
        return $this;
    }

    public function sendToTrash(Task $task) {
        $task->trash = 1;
        $task->save();

        return redirect()->action('Operational\\TaskController@index');
    }

    public function restoreFromTrash(Task $task) {
        $task->trash = 0;
        $task->save();

        return redirect()->back();
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

    // chama o método que completa a tarefa e direciona para a view show
    public function completeTask(task $task) {
        Task::completeTask($task);

        return redirect()->route('task.show', compact(
                                'task',
        ));
    }

    // chama o método que completa a tarefa e direciona para a view show
    public function monthlyCalendar() {
        $startMonth = new DateTime(date('Y-m-01'));
        $startDay = $startMonth->format('l');

        $month = date('m');
        $monthName = returnMonth($month);
        $totalDays = date('t');
        $counter = 1;
        $day = 1;

        switch ($startDay) {
            case 'Monday':
                $nullDays = 0;
                break;
            case 'Tuesday':
                $nullDays = 1;
                break;
            case 'Wednesday':
                $nullDays = 2;
                break;
            case 'Thursday':
                $nullDays = 3;
                break;
            case 'Friday':
                $nullDays = 4;
                break;
            case 'Saturday':
                $nullDays = 5;
                break;
            case 'Sunday':
                $nullDays = 6;
                break;
        }

        $month = returnMonth(date('m'));
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $myTasks = Task::where('user_id', auth()->user()->id)
//->where('date_due', '<', date('Y-m-d'))
                ->whereBetween('date_due', [$monthStart, $monthEnd])
                ->where('status', 'fazer')
                ->where('trash', '!=', 1)
                ->get();

//        $teamTasksPending = $teamTasks->where('status', 'fazer');
//        $teamTasksPendingCount = $teamTasksPending->count();
//        
//        $myTasks = $teamTasks->where('user_id', auth()->user()->id);
//        $myTasksCount = $myTasks->count();

        return view('operational.tasks.monthly_calendar', compact(
                        'startMonth',
                        'startDay',
                        'monthName',
                        'totalDays',
                        'counter',
                        'day',
                        'nullDays',
                        'myTasks',
        ));
    }

}

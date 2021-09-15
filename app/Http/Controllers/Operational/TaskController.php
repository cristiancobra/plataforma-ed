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

        $trashStatus = request()->trash;

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
                        'trashStatus',
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

        $opportunities = Opportunity::openOpportunities();

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
        
        $openJourney = Journey::myOpenJourney();

        return view('operational.tasks.showTask', compact(
                        'today',
                        'task',
                        'totalDuration',
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

//        $tasks = Task::whereHas('account', function ($query) {
//                    $query->where('account_id', auth()->user()->account_id);
//                })
//                ->with('contact')
//                ->paginate(20);

        $users = User::myUsers();

        $opportunities = Opportunity::openOpportunities();

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
            $dateStart = new DateTime($request->date_due . " " . $request->time_due);
            $task->date_due = $dateStart->format('Y-m-d H:i:s');

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

    function returnStatus() {
        return $status = array(
            'fazer',
            'aguardar',
            'feito',
            'fazendo',
            'cancelado',
        );
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

}

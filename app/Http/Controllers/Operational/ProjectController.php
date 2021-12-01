<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Goal;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Project;
use App\Models\Product;
use App\Models\Stage;
use App\Models\Task;
use App\Models\User;

class ProjectController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
//     if ($request->department == 'desenvolvimento') {
        $title = 'PROJETOS';
//            $department = 'desenvolvimento';
//        } else {
//            $title = 'OPORTUNIDADES';
//            $department = null;
//        }

        $projects = Project::filterProjects($request);
        $allProjects = Project::where('account_id', auth()->user()->account_id)
                ->where('trash', '!=', 1)
                ->get();

//        $totalProspection = $allProjects->where('stage', 'prospecção')->count();
//        $totalPresentation = $allProjects->where('stage', 'apresentação')->count();
//        $totalProposal = $allProjects->where('stage', 'proposta')->count();
//        $totalContract = $allProjects->where('stage', 'contrato')->count();
//        $totalBill = $allProjects->where('stage', 'cobrança')->count();
//        $totalProduction = $allProjects->where('stage', 'produção')->count();

        $total = $projects->total();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();
        $status = Project::returnStatus();

        $trashStatus = request()->trash;

        return view('operational.projects.index', compact(
                        'title',
                        'projects',
//                        'totalProspection',
//                        'totalPresentation',
//                        'totalProposal',
//                        'totalContract',
//                        'totalBill',
//                        'totalProduction',
                        'total',
                        'contacts',
                        'companies',
                        'users',
                        'status',
                        'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $title = 'PROJETOS';
//            $department = 'desenvolvimento';
//            $stages = null;
//            $status = Opportunity::listStatusDevelopment();
        $goals = Goal::openGoals();
//        } else {
//            $title = 'OPORTUNIDADES';
        $department = null;
//            $stages = Opportunity::listStages();
        $status = Project::returnStatus();
//            $goals = null;
//        }

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $products = Product::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        return view('operational.projects.create', compact(
                        'title',
                        'department',
                        'users',
                        'companies',
                        'contacts',
                        'products',
                        'goals',
                        'status',
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
                    'name' => 'required:projects',
                    'date_start' => 'required:projects',
                    'date_due' => 'required:projects',
                    'description' => 'required:projects',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $project = new Project();
            $project->fill($request->all());
            $project->account_id = auth()->user()->account_id;

            $project->user()->associate($request->user_id);
            $project->save();

            return redirect()->route('project.show', [$project]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        $title = 'PROJETOS';

        if ($project->company) {
            $companyName = $project->company->name;
            $companyId = $project->company->id;
        } else {
            $companyName = null;
            $companyId = null;
        }
        $contactCompanies = Company::whereHas('contacts', function ($query) use ($project) {
                    $query->where('contacts.id', $project->contact_id);
                })
                ->get();

        $stages = Stage::where('project_id', $project->id)
                ->orderBy('start', 'ASC')
                ->with('tasks')
                ->get();

        $tasksWithoutStage = Task::where('project_id', $project->id)
                ->where('stage_id', 0)
                ->get();

//        $proposals = Proposal::where('project_id', $project->id)
//                ->where('trash', '!=', 1)
//                ->orderBy('PAY_DAY', 'ASC')
//                ->get();
//        $proposalWon = $proposals->where('status', 'aprovada')->count();
//        $proposalApproved = Proposal::where('project_id', $project->id)
//                ->where('status', 'aprovada')
//                ->where('trash', '!=', 1)
//                ->first();
//
//        if ($proposalApproved != null) {
//
//            $invoices = Invoice::where('proposal_id', $proposalApproved->id)
//                    ->where('trash', '!=', 1)
//                    ->with('transactions')
//                    ->orderBy('PAY_DAY', 'ASC')
//                    ->get();
//
//            foreach ($invoices as $invoice) {
//                if ($invoice->status == 'aprovada') {
//                    $invoice->paid = Transaction::where('invoice_id', $invoice->id)
//                            ->sum('value');
//                }
//                if ($invoice->paid >= $invoice->totalPrice) {
//                    $invoice->status = 'paga';
//                } elseif ($invoice->paid > 0 AND $invoice->paid <= $invoice->totalPrice) {
//                    $invoice->status = 'parcial';
//                }
//
//                $invoice->balance = $invoice->totalPrice - $invoice->paid;
//            }
//
//            $invoiceInstallmentsTotal = $invoices->where('status', 'aprovada')->sum('installment_value');
//            $invoicePaymentsTotal = $invoices->sum('balance');
//            $balanceTotal = $invoiceInstallmentsTotal + $invoicePaymentsTotal;
//        } else {
//            $invoices = [];
//            $invoiceInstallmentsTotal = 0;
//            $invoicePaymentsTotal = 0;
//            $balanceTotal = 0;
//        }
//
//        foreach ($tasks as $task) {
//            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
//                $task->status = 'fazendo';
//            } elseif ($task->status == 'fazer' AND $task->date_due <= date('Y-m-d')) {
//                $task->status = 'atrasada';
//            }
//        }
//
//        $tasksSales = $tasks->where('department', '=', 'vendas');
//
//        $tasksSalesHours = Journey::whereHas('task', function ($query) use ($project) {
//                    $query->where('project_id', $project->id);
//                    $query->where('department', '=', 'vendas');
//                })
//                ->sum('duration');
//
//        $tasksDevelopment = $tasks->where('department', 'desenvolvimento');
//        foreach ($tasksDevelopment as $task) {
//            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
//                $task->status = 'fazendo';
//            }
//        }

        $tasks = Task::where('project_id', $project->id)
                ->with('journeys')
                ->get();

        $tasksOperational = $tasks->where('department', 'produção');
        foreach ($tasksOperational as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            }
        }
//
////        dd($tasksOperational);
        $tasksOperationalHours = Journey::whereHas('task', function ($query) use ($project) {
                    $query->where('project_id', $project->id);
                    $query->where('department', '=', 'produção');
                })
                ->with('journeys')
                ->sum('duration');
//
//        $tasksCustomerServices = $tasks->where('department', '=', 'atendimento');
//        foreach ($tasksOperational as $task) {
//            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
//                $task->status = 'fazendo';
//            }
//            if ($task->status == 'fazer' AND $task->date_due <= date('Y-m-d')) {
//                $task->status = 'atrasada';
//            }
//        }
//
//        $tasksCustomerServicesHours = Journey::whereHas('task', function ($query) use ($project) {
//                    $query->where('project_id', $project->id);
//                    $query->where('department', '=', 'atendimento');
//                })
//                ->sum('duration');
//
//        $contracts = Contract::where('project_id', $project->id)
//                ->get();

        $users = User::myUsers();
        $status = Task::returnStatus();
        $departments = Task::returnDepartments();
        $priorities = Task::returnPriorities();

        $counter = 1;

        return view('operational.projects.show', compact(
                        'title',
                        'project',
                        'companyName',
                        'companyId',
                        'stages',
                        'tasksWithoutStage',
//                        'proposals',
//                        'proposalWon',
//                        'invoices',
//                        'invoiceInstallmentsTotal',
//                        'invoicePaymentsTotal',
//                        'balanceTotal',
//                        'tasks',
//                        'tasksSales',
//                        'tasksSalesHours',
//                        'tasksDevelopment',
//                        'tasksOperational',
                        'tasksOperationalHours',
//                        'tasksCustomerServices',
//                        'tasksCustomerServicesHours',
//                        'contracts',
                        'contactCompanies',
                        'users',
                        'status',
                        'departments',
                        'priorities',
                        'counter',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        $title = 'PROJETOS';
        $status = Project::returnStatus();

        $projects = Project::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $goals = Goal::openGoals();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('operational.projects.edit', compact(
                        'title',
                        'project',
                        'users',
                        'goals',
                        'contacts',
                        'companies',
                        'projects',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project) {
        $project->fill($request->all());
        $project->user()->associate($request->user_id);
        $project->save();

        return redirect()->route('project.show', [$project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        //
    }

    public function sendToTrash(Project $project) {
        $project->trash = 1;
        $project->save();

        return redirect()->action('Operational\\ProjectController@index');
    }

    public function restoreFromTrash(Project $project) {
        $project->trash = 0;
        $project->save();

        return redirect()->action('Operational\\ProjectController@index');
    }

    public function jsonStages(Project $project) {
        $stages = Stage::where('project_id', $project->id)
                ->get();

        return response()->json($stages);
    }

}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Company;
use App\Models\Goal;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Stage;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class OpportunityController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title = 'OPORTUNIDADES';
        $department = null;

        $opportunities = Opportunity::filterOpportunities($request);
        $allOpportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->where('status', '!=', 'perdemos')
                ->where('stage', '!=', 'concluída')
                ->where('trash', '!=', 1)
                ->get();

        $totalProspection = $allOpportunities->where('stage', 'prospecção')->count();
        $totalPresentation = $allOpportunities->where('stage', 'apresentação')->count();
        $totalProposal = $allOpportunities->where('stage', 'proposta')->count();
        $totalContract = $allOpportunities->where('stage', 'contrato')->count();
        $totalBill = $allOpportunities->where('stage', 'cobrança')->count();
        $totalProduction = $allOpportunities->where('stage', 'produção')->count();

        $total = $opportunities->total();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();
        $stages = Opportunity::listStages();
        $status = Opportunity::listStatus();

        $trashStatus = request()->trash;

        return view('sales.opportunities.index', compact(
                        'title',
                        'department',
                        'opportunities',
                        'totalProspection',
                        'totalPresentation',
                        'totalProposal',
                        'totalContract',
                        'totalBill',
                        'totalProduction',
                        'total',
                        'contacts',
                        'companies',
                        'users',
                        'stages',
                        'status',
                        'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $title = 'OPORTUNIDADES';
        $department = null;
        $stages = Opportunity::listStages();
        $status = Opportunity::listStatus();
        $goals = null;

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

        return view('sales.opportunities.create', compact(
                        'title',
                        'department',
                        'users',
                        'companies',
                        'contacts',
                        'products',
                        'stages',
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
        $opportunity = new Opportunity();
        $opportunity->fill($request->all());
        $opportunity->account_id = auth()->user()->account_id;

        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'name' => 'required:opportunities',
                    'date_start' => 'required:opportunities',
                    'date_due' => 'required:opportunities',
                    'description' => 'required:opportunities',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $opportunity->user()->associate($request->user_id);
            $opportunity->save();

            return redirect()->route('opportunity.show', [$opportunity]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function show(Opportunity $opportunity) {
        $title = 'OPORTUNIDADES';
        $dateDue = 'PRÓXIMO CONTATO';

        if ($opportunity->company) {
            $companyName = $opportunity->company->name;
            $companyId = $opportunity->company->id;
        } else {
            $companyName = null;
            $companyId = null;
        }
        $contactCompanies = Company::whereHas('contacts', function ($query) use ($opportunity) {
                    $query->where('contacts.id', $opportunity->contact_id);
                })
                ->get();

        $proposals = Proposal::where('opportunity_id', $opportunity->id)
                ->where('trash', '!=', 1)
//                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        $proposalWon = $proposals->where('status', 'aprovada')->count();

        $proposalApproved = Proposal::where('opportunity_id', $opportunity->id)
                ->where('status', 'aprovada')
                ->where('trash', '!=', 1)
                ->first();

        if ($proposalApproved != null) {
            $invoiceFrameColor = auth()->user()->account->principal_color;

            $invoices = Invoice::where('proposal_id', $proposalApproved->id)
                    ->where('trash', '!=', 1)
                    ->with('transactions')
                    ->orderBy('PAY_DAY', 'ASC')
                    ->get();

            $invoicesCount = $invoices->count();

            $invoicesTotal = 0;
            $balanceTotal = 0;

            foreach ($invoices as $invoice) {
                $invoice->color = Invoice::statusColor($invoice);
                
                if ($invoice->status == 'aprovada') {
                    $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                            ->sum('value');
                }
                if ($invoice->paid >= $invoice->totalPrice) {
                    $invoice->status = 'paga';
                } elseif ($invoice->paid > 0 AND $invoice->paid <= $invoice->totalPrice) {
                    $invoice->status = 'parcial';
                }

                $invoice->balance = $invoice->totalPrice - $invoice->paid;

                $invoicesTotal += $invoice->totalPrice;
                $balanceTotal += $invoice->balance;
            }


            $invoiceInstallmentsTotal = $invoices->where('status', 'aprovada')->sum('installment_value');
            $invoicePaymentsTotal = $invoices->sum('balance');
            $balanceTotal = $invoiceInstallmentsTotal + $invoicePaymentsTotal;
        } else {
            $invoices = [];
            $invoiceInstallmentsTotal = 0;
            $invoicePaymentsTotal = 0;
            $invoicesTotal = 0;
            $balanceTotal = 0;
            $invoicesCount = 0;
            $invoiceFrameColor = 'lightgray';
        }
                
        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $stages = Stage::where('opportunity_id', $opportunity->id)
                ->with('tasks')
                ->get();

        $tasks = Task::where('opportunity_id', $opportunity->id)
                ->with('journeys')
                ->get();

        foreach ($tasks as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            } elseif ($task->status == 'fazer' AND $task->date_due <= date('Y-m-d')) {
                $task->status = 'atrasada';
            }
        }
//dd($tasks);
        $tasksSales = $tasks->where('department', '=', 'vendas');

        $tasksSalesHours = Journey::whereHas('task', function ($query) use ($opportunity) {
                    $query->where('opportunity_id', $opportunity->id);
                    $query->where('department', '=', 'vendas');
                })
                ->sum('duration');

        $tasksDevelopment = $tasks->where('department', 'desenvolvimento');
        foreach ($tasksDevelopment as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            }
        }

        $tasksOperational = $tasks->where('department', 'produção');
        foreach ($tasksOperational as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            }
        }

//        dd($tasksOperational);
        $tasksOperationalHours = Journey::whereHas('task', function ($query) use ($opportunity) {
                    $query->where('opportunity_id', $opportunity->id);
                    $query->where('department', '=', 'produção');
                })
                ->with('journeys')
                ->sum('duration');

        $tasksCustomerServices = $tasks->where('department', '=', 'atendimento');
        foreach ($tasksOperational as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            }
            if ($task->status == 'fazer' AND $task->date_due <= date('Y-m-d')) {
                $task->status = 'atrasada';
            }
        }

        $tasksCustomerServicesHours = Journey::whereHas('task', function ($query) use ($opportunity) {
                    $query->where('opportunity_id', $opportunity->id);
                    $query->where('department', '=', 'atendimento');
                })
                ->sum('duration');

        $contracts = Contract::where('opportunity_id', $opportunity->id)
                ->get();

        $users = User::myUsers();
        $status = Task::returnStatus();
        $departments = Task::returnDepartments();
        $priorities = Task::returnPriorities();

        $counter = 1;

        return view('sales.opportunities.show', compact(
                        'dateDue',
                        'title',
                        'opportunity',
                        'companyName',
                        'companyId',
                        'proposals',
                        'proposalWon',
                        'proposalApproved',
                        'invoices',
                        'invoicesCount',
                        'invoiceFrameColor',
                        'invoiceInstallmentsTotal',
                        'invoicePaymentsTotal',
                        'invoicesTotal',
                        'balanceTotal',
                        'bankAccounts',
                        'stages',
                        'tasks',
                        'tasksSales',
                        'tasksSalesHours',
                        'tasksDevelopment',
                        'tasksOperational',
                        'tasksOperationalHours',
                        'tasksCustomerServices',
                        'tasksCustomerServicesHours',
                        'contracts',
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
     * @param  \App\Models\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function edit(Opportunity $opportunity) {
        $title = 'OPORTUNIDADES';
        $stages = Opportunity::listStages();
        $status = Opportunity::listStatus();

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $invoices = Invoice::where('opportunity_id', $opportunity->id)
                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        return view('sales.opportunities.edit', compact(
                        'title',
                        'opportunity',
                        'users',
                        'contacts',
                        'companies',
                        'opportunities',
                        'invoices',
                        'stages',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Opportunity $opportunity) {
        $opportunity->fill($request->all());
        $opportunity->user()->associate($request->user_id);
        $opportunity->save();

        return redirect()->route('opportunity.show', [$opportunity]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Opportunity $opportunity) {
        $opportunity->delete();
        return redirect()->action('Sales\\OpportunityController@index');
    }

    // Filtra oportunidades de acordo com parâmetros fornecidos
    public function filter(Request $request) {
        $opportunities = Opportunity::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                    if ($request->user_id) {
                        $query->where('user_id', '=', $request->user_id);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', '=', $request->contact_id);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', '=', $request->company_id);
                    }
                    if ($request->stage) {
                        $query->where('stage', '=', $request->stage);
                    }
                    if ($request->status) {
                        $query->where('status', '=', $request->status);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->with([
                    'user',
                    'account',
                    'company',
                    'contact',
                ])
                ->orderBy('DATE_CONCLUSION', 'ASC')
                ->paginate(20);

        $total = $opportunities->total();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();
        $stages = Opportunity::listStages();
        $status = Opportunity::listStatus();

        return view('sales.opportunities.indexOpportunities', compact(
                        'opportunities',
                        'total',
                        'contacts',
                        'companies',
                        'users',
                        'stages',
                        'status',
        ));
    }

    public function sendToTrash(Opportunity $opportunity) {
        $opportunity->trash = 1;
        $opportunity->save();

        return redirect()->action('Sales\\OpportunityController@index');
    }

    public function restoreFromTrash(Opportunity $opportunity) {
        $opportunity->trash = 0;
        $opportunity->save();

        return redirect()->action('Sales\\OpportunityController@index');
    }

    // Gera PDF do relatório de produção da proposta
    public function createProductionPdf(Opportunity $opportunity) {
//        $proposal = Proposal::where('opportunity_id', $opportunity->id)
//                ->where('status', 'aprovada')
//                ->with('invoices.transactions')
//                ->first();
//dd($proposal);
//        $totalTransactions = $proposal->invoices->transactions->sum('value');
//        $proposalLines = ProductProposal::where('proposal_id', $proposal->id)
//                ->with('product', 'opportunity')
//                ->get();
//        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
//                ->where('status', 'LIKE', 'recebendo')
//                ->with([
//                    'account.image',
//                    'bank',
//                ])
//                ->get();

        $tasksOperational = Task::where('opportunity_id', $opportunity->id)
                ->where('department', '=', 'produção')
                ->with('journeys')
                ->get();

        foreach ($tasksOperational as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'fazendo';
            } elseif ($task->status == 'fazer' AND $task->date_due <= date('Y-m-d')) {
                $task->status = 'atrasada';
            }
        }

        $tasksOperationalPoints = $tasksOperational
                ->sum('points');

        $tasksOperationalPointsExecuted = $tasksOperational
                ->where('status', 'feito')
                ->sum('points');

// definição do título
//        if ($proposal->status == 'orçamento' OR $proposal->status == 'rascunho') {
//            $pdfTitle = 'ORÇAMENTO';
//        } elseif ($proposal->status == 'aprovada' OR $proposal->status == 'paga') {
        $pdfTitle = 'RELATÓRIO DE PRODUÇÃO';
//        }

        if ($opportunity->company_id) {
            $email = $opportunity->company->email;
            $phone = $opportunity->company->phone;
            $address = $opportunity->company->address;
            $city = $opportunity->company->city;
            $state = $opportunity->company->state;
            $country = $opportunity->company->country;
            $companyName = $opportunity->company->name;
            $companyCnpj = $opportunity->company->cnpj;
            $contactCpf = null;
        } else {
            $email = $opportunity->contact->email;
            $phone = $opportunity->contact->phone;
            $address = $opportunity->contact->address;
            $city = $opportunity->contact->city;
            $state = $opportunity->contact->state;
            $country = $opportunity->contact->country;
            $companyName = null;
            $companyCnpj = null;
            $contactCpf = $opportunity->contact->cpf;
        }

        $data = [
            'pdfTitle' => $pdfTitle,
            'accountLogo' => $opportunity->account->image->path,
            'accountPrincipalColor' => $opportunity->account->principal_color,
            'accountComplementaryColor' => $opportunity->account->complementary_color,
            'accountName' => $opportunity->account->name,
            'accountEmail' => $opportunity->account->email,
            'accountPhone' => $opportunity->account->phone,
            'accountAddress' => $opportunity->account->address,
            'accountCity' => $opportunity->account->city,
            'accountState' => $opportunity->account->state,
            'accountCnpj' => $opportunity->account->cnpj,
//            'taskDescription' => $task->description,
//            'customerName' => $task->contact->name,
            'companyName' => $companyName,
            'companyCnpj' => $companyCnpj,
            'contactCpf' => $contactCpf,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country,
//            'bankAccounts' => $bankAccounts,
            'invoiceIdentifier' => $opportunity->identifier,
            'invoiceDescription' => $opportunity->description,
            'invoiceDiscount' => $opportunity->discount,
            'invoiceExpirationDate' => $opportunity->expiration_date,
            'invoiceInstallmentValue' => $opportunity->installment_value,
            'invoiceStatus' => $opportunity->status,
            'invoiceNumberInstallmentTotal' => $opportunity->number_installment_total,
            'invoiceTotalPrice' => $opportunity->installment_value,
            'opportunityDescription' => $opportunity->description,
            'invoiceDiscount' => $opportunity->discount,
            'invoicePayday' => $opportunity->pay_day,
            'invoiceTotalPrice' => $opportunity->totalPrice,
            'customerName' => $opportunity->contact->name,
//            'invoiceLines' => $proposalLines,
//            'invoiceTotalTransactions' => $totalTransactions,
            'tasksOperational' => $tasksOperational,
            'tasksOperationalPoints' => $tasksOperationalPoints,
            'tasksOperationalPointsExecuted' => $tasksOperationalPointsExecuted,
        ];
//        dd($data);
        $header = view('layouts/pdfHeader', compact('data'))->render();
        $footer = view('layouts/pdfFooter', compact('data'))->render();
        $pdf = PDF::loadView('sales.proposals.pdf_production', compact('data'))
                ->setOptions([
            'page-size' => 'A4',
            'header-html' => $header,
            'footer-html' => $footer,
        ]);

// download PDF file with download method
        return $pdf->stream('Relatorio.pdf');
    }

}

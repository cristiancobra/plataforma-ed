<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class OpportunityController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $opportunities = Opportunity::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    $query->where('stage', '!=', 'concluída');
                    $query->where('status', '!=', 'perdemos');
                    $query->where('trash', '==', 0);
                }
                )
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $products = Product::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $stages = Opportunity::listStages();
        $status = Opportunity::listStatus();
        $users = User::myUsers();

        return view('sales.opportunities.createOpportunity', compact(
                        'users',
                        'companies',
                        'contacts',
                        'products',
                        'stages',
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
                    'date_conclusion' => 'required:opportunities',
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
        $contactCompanies = Company::whereHas('contacts', function ($query) use ($opportunity) {
                    $query->where('contacts.id', $opportunity->contact_id);
                })
                ->get();

        $proposals = Proposal::where('opportunity_id', $opportunity->id)
//                ->with('transactions')
//                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        $invoices = Invoice::where('opportunity_id', $opportunity->id)
                ->where('trash', '==', 0)
                ->with('transactions')
                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        foreach ($invoices as $invoice) {
            if ($invoice->status == 'aprovada') {
                $invoice->paid = Transaction::where('invoice_id', $invoice->id)
//                    ->where('department', '=', 'vendas')
                        ->sum('value');
            }
            if ($invoice->paid >= $invoice->installment_value) {
                $invoice->status = 'paga';
            } elseif ($invoice->paid > 0 AND $invoice->paid <= $invoice->installment_value) {
                $invoice->status = 'parcial';
            }

            $invoice->balance = $invoice->installment_value - $invoice->paid;
        }

        $invoiceInstallmentsTotal = $invoices->where('status', 'aprovada')->sum('installment_value');
        $invoicePaymentsTotal = $invoices->sum('balance');
        $balanceTotal = $invoiceInstallmentsTotal + $invoicePaymentsTotal;

        $tasks = Task::where('opportunity_id', $opportunity->id)
                ->get();

        foreach ($tasks as $task) {
            if ($task->status == 'fazer' AND $task->journeys()->exists()) {
                $task->status = 'andamento';
            } elseif ($task->status == 'fazer' AND $task->date_due <= date('Y-m-d')) {
                $task->status = 'atrasada';
            }
        }

        $tasksSales = Task::where('opportunity_id', $opportunity->id)
                ->where('department', '=', 'vendas')
                ->get();

        $tasksSalesHours = Journey::whereHas('task', function ($query) use ($opportunity) {
                    $query->where('opportunity_id', $opportunity->id);
                    $query->where('department', '=', 'vendas');
                })
                ->sum('duration');

        $tasksOperational = Task::where('opportunity_id', $opportunity->id)
                ->where('department', '=', 'produção')
                ->get();

        $tasksOperationalHours = Journey::whereHas('task', function ($query) use ($opportunity) {
                    $query->where('opportunity_id', $opportunity->id);
                    $query->where('department', '=', 'produção');
                })
                ->sum('duration');

        $tasksCustomerServices = Task::where('opportunity_id', $opportunity->id)
                ->where('department', '=', 'atendimento')
                ->get();

        $tasksCustomerServicesHours = Journey::whereHas('task', function ($query) use ($opportunity) {
                    $query->where('opportunity_id', $opportunity->id);
                    $query->where('department', '=', 'atendimento');
                })
                ->sum('duration');

        $contracts = Contract::where('opportunity_id', $opportunity->id)
                ->get();

        return view('sales.opportunities.showOpportunity', compact(
                        'opportunity',
                        'proposals',
                        'invoices',
                        'invoiceInstallmentsTotal',
                        'invoicePaymentsTotal',
                        'balanceTotal',
                        'tasks',
                        'tasksSales',
                        'tasksSalesHours',
                        'tasksOperational',
                        'tasksOperationalHours',
                        'tasksCustomerServices',
                        'tasksCustomerServicesHours',
                        'contracts',
                        'contactCompanies',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function edit(Opportunity $opportunity) {
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

        $stages = Opportunity::listStages();
        $status = Opportunity::listStatus();

        return view('sales.opportunities.editOpportunity', compact(
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


}

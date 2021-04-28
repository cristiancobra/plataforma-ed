<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\Task;
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
                    $query->whereIn('account_id', userAccounts());
                    $query->where('stage', '!=', 'ganhamos');
                    $query->where('stage', '!=', 'perdemos');
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

        return view('sales.opportunities.indexOpportunities', compact(
                        'opportunities',
                        'total',
                        'contacts',
                        'companies',
                        'accounts',
                        'users',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $opportunity = new Opportunity();

        $accountsId = userAccounts();

        $accounts = Account::whereIn('id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = myUsers();

        $companies = Company::whereIn('account_id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::whereIn('account_id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $products = Product::whereIn('account_id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $stages = returnOpportunitiesStage();

        return view('sales.opportunities.createOpportunity', compact(
                        'opportunity',
                        'accounts',
                        'users',
                        'companies',
                        'contacts',
                        'products',
                        'stages',
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

            $invoices = Invoice::where('opportunity_id', $opportunity->id)
                    ->orderBy('PAY_DAY', 'ASC')
                    ->get();

            $tasks = Task::where('opportunity_id', $opportunity->id)
                    ->get();

            $contracts = Contract::where('opportunity_id', $opportunity->id)
                    ->get();

            $contactCompanies = Company::whereHas('contacts', function ($query) use ($opportunity) {
                        $query->where('contacts.id', $opportunity->contact_id);
                    })
                    ->get();

            return view('sales.opportunities.showOpportunity', compact(
                            'opportunity',
                            'invoices',
                            'tasks',
                            'contracts',
                            'contactCompanies',
            ));
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
//		dd($contactCompanies);
        $invoices = Invoice::where('opportunity_id', $opportunity->id)
                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        $tasks = Task::where('opportunity_id', $opportunity->id)
                ->get();

        $contracts = Contract::where('opportunity_id', $opportunity->id)
                ->get();

        return view('sales.opportunities.showOpportunity', compact(
                        'opportunity',
                        'invoices',
                        'tasks',
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
        $accountsId = Account::whereHas('users', function ($query) {
                    $query->where('users.id', Auth::user()->id);
                })
                ->pluck('id');

        $accounts = Account::whereHas('users', function ($query) use ($accountsId) {
                    $query->whereIn('account_id', $accountsId);
                })
                ->get();

        $opportunities = Opportunity::whereIn('account_id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = myUsers();

        $companies = Company::whereIn('account_id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::whereIn('account_id', $accountsId)
                ->orderBy('NAME', 'ASC')
                ->get();

        $invoices = Invoice::where('opportunity_id', $opportunity->id)
                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        $stages = returnOpportunitiesStage();

        return view('sales.opportunities.editOpportunity', compact(
                        'opportunity',
                        'accounts',
                        'users',
                        'contacts',
                        'companies',
                        'opportunities',
                        'invoices',
                        'stages',
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

        $invoices = Invoice::where('opportunity_id', $opportunity->id)
                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        $tasks = Task::where('opportunity_id', $opportunity->id)
                ->get();

        $contracts = Contract::where('opportunity_id', $opportunity->id)
                ->get();

        $contactCompanies = Company::whereHas('contacts', function ($query) use ($opportunity) {
                    $query->where('contacts.id', $opportunity->contact_id);
                })
                ->get();

        return view('sales.opportunities.showOpportunity', compact(
                        'opportunity',
                        'invoices',
                        'tasks',
                        'contracts',
                        'contactCompanies',
        ));
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
                    if ($request->account_id) {
                        $query->where('account_id', '=', $request->account_id);
                    } else {
                        $query->whereIn('account_id', userAccounts());
                    }
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
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    }else{
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

        return view('sales.opportunities.indexOpportunities', compact(
                        'opportunities',
                        'total',
                        'contacts',
                        'companies',
                        'accounts',
                        'users',
        ));
    }

    public function trash(Request $request, Opportunity $opportunity) {
        $opportunity->trash = 1;
        $opportunity->save();

        return redirect()->action('Sales\\OpportunityController@index');
    }

}

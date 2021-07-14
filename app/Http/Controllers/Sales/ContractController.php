<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Opportunity;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;

class ContractController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $contracts = Contract::where('account_id', auth()->user()->account_id)
                ->with([
                    'contact',
                    'account',
                    'company',
                    'opportunity',
                    'user',
                    'userContact',
                    'invoice.invoiceLines.product',
                ])
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $contracts->count();

        return view('sales.contracts.indexContracts', compact(
                        'contracts',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users = User::whereHas('accounts', function ($query) {
                    $query->where('accounts.id', auth()->user()->account_id);
                })
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->orderBy('IDENTIFIER', 'DESC')
                ->get();

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contractsTemplates = ContractTemplate::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('sales.contracts.createContract', compact(
                        'users',
                        'invoices',
                        'opportunities',
                        'contacts',
                        'contractsTemplates',
                        'companies',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $contract = new Contract;
        $contract->fill($request->all());
        $contractTemplate = ContractTemplate::find($request->contractTemplate_id)->first();
        $contract->text = $contractTemplate->text;
        $contract->identifier = $this->generateIdentifier($request);
        $contract->save();

        return redirect()->route('conrtact.show', compact('contract'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract) {
        $users = User::myUsers();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $invoiceLines = InvoiceLine::where('invoice_id', $contract->invoice_id)
                ->with('product', 'opportunity')
                ->get();

        $userContact = userContact($contract->user_id);

        $witness1 = Contact::find($contract->witness1);
        $witnessName1 = $witness1->name;

        $witness2 = Contact::find($contract->witness2);
        $witnessName2 = $witness2->name;

        return view('sales.contracts.showContract', compact(
                        'contract',
                        'users',
                        'opportunities',
                        'contacts',
                        'invoiceLines',
                        'userContact',
                        'witnessName1',
                        'witnessName2',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract) {
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->orderBy('IDENTIFIER', 'DESC')
                ->get();

        $witness1 = Contact::find($contract->witness1);
        $witnessName1 = $witness1->name;

        $witness2 = Contact::find($contract->witness2);
        $witnessName2 = $witness2->name;

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contractsTemplates = ContractTemplate::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::whereHas('accounts', function ($query) {
                    $query->where('accounts.id', auth()->user()->account_id);
                })
                ->get();

        $userContact = userContact($contract->user_id);

        return view('sales.contracts.editContract', compact(
                        'contract',
                        'opportunities',
                        'contacts',
                        'companies',
                        'invoices',
                        'witnessName1',
                        'witnessName2',
                        'contractsTemplates',
                        'users',
                        'userContact',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract) {
        $contract->fill($request->all());
        $contract->identifier = $this->generateIdentifier($request, $contract->identifier);
        $contract->save();

        return redirect()->route('contract.show', compact('contract'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract) { {
            $contract->delete();
            return redirect()->action('Sales\\ContractController@index');
        }
    }

    // Gerar identificador para contrato
    public function generateIdentifier($request, $currentIdentifier = null) {
        $contractIdentifiers = Contract::where('account_id', $request->account_id)
                ->pluck('identifier')
                ->toArray();

        // Se for rascunho ou orçamento atribui ID zero
        if ($request->status != 'rascunho' AND $currentIdentifier > 0) {
            $identifier = $currentIdentifier;
        } elseif ($request->status == 'rascunho') {
            $identifier = 0;
        } elseif ($contractIdentifiers == null) {
            $identifier = 1;
        } else {
            $identifier = max($contractIdentifiers) + 1;
        }
        return $identifier;
    }

// Generate PDF
    public function createPDF(Contract $contract) {

        $totalTransactions = Transaction::whereHas('invoice', function ($query) use ($contract) {
                    $query->where('invoice_id', $contract->invoice_id);
                })
                ->sum('value');

        $invoiceLines = InvoiceLine::where('invoice_id', $contract->invoice_id)
                ->with('product', 'opportunity')
                ->get();

        $tasksOperational = Task::where('opportunity_id', $contract->invoice->opportunity_id)
                ->where('department', '=', 'produção')
                ->with('journeys')
                ->get();

        $tasksOperationalPoints = $tasksOperational
                ->sum('points');

        $tasksOperationalPointsExecuted = $tasksOperational
                ->where('status', 'feito')
                ->sum('points');

        $witness1 = Contact::find($contract->witness1);
        $witnessName1 = $witness1->name;

        $witness2 = Contact::find($contract->witness2);
        $witnessName2 = $witness2->name;

        // definição do título
        $pdfTitle = 'CONTRATO';

        $data = [
            'pdfTitle' => $pdfTitle,
            // dados da empresa contratada
            'accountLogo' => $contract->account->image->path,
            'accountPrincipalColor' => $contract->account->principal_color,
            'accountComplementaryColor' => $contract->account->complementary_color,
            'accountName' => $contract->account->name,
            'accountId' => $contract->account->id,
            'accountEmail' => $contract->account->email,
            'accountPhone' => $contract->account->phone,
            'accountAddress' => $contract->account->address,
            'accountCity' => $contract->account->city,
            'accountState' => $contract->account->state,
            'accountZipCode' => $contract->account->zip_code,
            'accountCnpj' => $contract->account->cnpj,
            // dados do RESPONSAVEL pela empresa contratada
            'userName' => $contract->user->contact->name,
            'userId' => $contract->user->id,
            'userAddress' => $contract->user->contact->address,
            'userCity' => $contract->user->contact->city,
            'userState' => $contract->user->contact->state,
            'userZipCode' => $contract->user->contact->zip_code,
            'userCpf' => $contract->user->contact->cpf,
            // dados da empresa contratante
            'companyName' => $contract->company->name,
            'companyId' => $contract->company->id,
            'companyAddress' => $contract->company->address,
            'companyCity' => $contract->company->city,
            'companyState' => $contract->company->state,
            'companyZipCode' => $contract->company->zip_code,
            'companyCnpj' => $contract->company->cnpj,
            // dados do RESPONSAVEL pela empresa contratante
            'contactName' => $contract->contact->name,
            'contactId' => $contract->contact->id,
            'contactAddress' => $contract->contact->address,
            'contactCity' => $contract->contact->city,
            'contactState' => $contract->contact->state,
            'contactZipCode' => $contract->contact->zip_code,
            'contactCpf' => $contract->contact->cpf,
            // dados do Contrato
            'contractIdentifier' => $contract->identifier,
            'contractObservations' => $contract->observations,
            'contractName' => $contract->name,
            'contractText' => $contract->text,
            'contractDateDue' => $contract->date_due,
            'contractDateStart' => $contract->date_start,
            'contractWitness1' => $witnessName1,
            'contractWitness2' => $witnessName2,
            // outros dados
            'invoiceIdentifier' => $contract->invoice->identifier,
            'invoiceDescription' => $contract->invoice->description,
            'invoiceDiscount' => $contract->invoice->discount,
            'invoiceInstallmentValue' => $contract->invoice->installment_value,
            'invoiceStatus' => $contract->invoice->status,
            'invoiceNumberInstallmentTotal' => $contract->invoice->number_installment_total,
            'invoiceTotalPrice' => $contract->invoice->totalPrice,
            'opportunityDescription' => $contract->opportunity->description,
            'invoiceDiscount' => $contract->invoice->discount,
            'invoicePayday' => $contract->invoice->pay_day,
            'invoiceTotalPrice' => $contract->invoice->totalPrice,
            'customerName' => $contract->contact->name,
            'customerEmail' => $contract->contact->email,
            'customerPhone' => $contract->contact->phone,
            'customerAddress' => $contract->contact->address,
            'customerCity' => $contract->contact->city,
            'customerState' => $contract->contact->state,
            'customerCountry' => $contract->contact->country,
            'invoiceLines' => $invoiceLines,
            'invoiceTotalTransactions' => $totalTransactions,
            'tasksOperational' => $tasksOperational,
            'tasksOperationalPoints' => $tasksOperationalPoints,
            'tasksOperationalPointsExecuted' => $tasksOperationalPointsExecuted,
        ];

        $header = view('layouts/pdfHeader', compact('data'))->render();
        $footer = view('layouts/pdfFooter', compact('data'))->render();
        $pdf = PDF::loadView('sales.contracts.pdfContract', compact('data'))
                ->setOptions([
            'page-size' => 'A4',
            'header-html' => $header,
            'footer-html' => $footer,
        ]);

// download PDF file with download method
        return $pdf->stream("Contrato-" . $contract->company->name . ".pdf");
    }

}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\ProductProposal;
use App\Models\Proposal;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use DateTime;

class ProposalController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $proposals = Proposal::where('account_id', auth()->user()->account_id)
                ->with([
                    'account',
                    'invoices',
//                    'opportunity',
//                    'invoiceLines.product',
//                    'account.bankAccounts',
//                    'user.contact',
//                    'contract',
                ])
                ->orderBy('pay_day', 'DESC')
                ->paginate(20);

//        $proposals->appends([
//            'status' => $request->status,
//            'contact_id' => $request->contact_id,
//            'user_id' => $request->user_id,
//        ]);

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();
        $types = Proposal::returnTypes();

        $total = $proposals->total();

        return view('sales.proposals.index', compact(
                        'proposals',
                        'contacts',
                        'companies',
                        'users',
                        'types',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $typeInvoices = $request->input('typeInvoices');

        if ($typeInvoices == 'receita') {
            $typeCompanies = 'cliente';
        } else {
            $typeCompanies = 'fornecedor';
        }

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->where('type', $typeCompanies)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->where('stage', '!=', 'perdemos')
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::where('account_id', auth()->user()->account_id)
                ->with('contact')
                ->orderBy('ID', 'ASC')
                ->get();

        $products = Product::where('account_id', auth()->user()->account_id)
                ->where('type', 'LIKE', $typeInvoices)
                ->where('status', 'disponível')
                ->orderBy('NAME', 'ASC')
                ->get();

        $types = Proposal::returnTypes();

        return view('sales.proposals.create', compact(
                        'request',
                        'opportunities',
                        'contacts',
                        'companies',
                        'products',
                        'users',
                        'types',
                        'typeInvoices',
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

        if ($request->status == 'receita') {
            $validator = Validator::make($request->all(), [
                        'pay_day' => 'required:invoices',
                        'date_creation' => 'required:invoices',
                        'opportunity_id' => 'required:invoices',
                            ],
                            $messages);
        } else {
            $validator = Validator::make($request->all(), [
                        'pay_day' => 'required:invoices',
                        'date_creation' => 'required:invoices',
//					'opportunity_id' => 'required:invoices',
                            ],
                            $messages);
        }
        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $proposal = new Proposal();
            $proposal->fill($request->all());
            $proposal->account_id = auth()->user()->account_id;

            $proposalsIdentifier = Proposal::where('account_id', $request->account_id)
                    ->pluck('identifier')
                    ->toArray();

            // Se for rascunho ou orçamento atribui ID zero
            if ($request->status == 'rascunho' OR $request->status == 'orçamento') {
                $proposal->identifier = 0;
            } elseif ($proposalsIdentifier == null) {
                $proposal->identifier = 1;
            } else {
                $proposal->identifier = max($proposalsIdentifier) + 1;
            }

            $proposal->save();

            // Cria e salva uma InvoiceLine para cada PRODUTO com quantidade maior que zero
            $totalPrice = 0;
            $totalTaxrate = 0;
            foreach ($request->product_id as $key => $value) {
                if ($request->product_amount [$key] > 0) {
                    $data = array(
                        'proposal_id' => $proposal->id,
                        'product_id' => $request->product_id [$key],
                        'amount' => $request->product_amount [$key],
                        'subtotalHours' => $request->product_amount [$key] * $request->product_work_hours [$key],
                        'subtotalDeadline' => $request->product_amount [$key] * $request->product_due_date [$key],
                        'subtotalCost' => $request->product_amount [$key] * $request->product_cost [$key],
                        'subtotalTax_rate' => $request->product_amount [$key] * $request->product_tax_rate [$key],
                        'subtotalMargin' => $request->product_amount [$key] * $request->product_margin [$key],
                        'subtotalPrice' => $request->product_amount [$key] * removeCurrency($request->product_price [$key]),
                    );
                    $totalPrice = $totalPrice + $data['subtotalPrice'];
                    $totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
                    ProductProposal::insert($data);
                }
            }
            $proposal->totalPrice = $totalPrice - str_replace(",", ".", $request->discount);
            $proposal->installment = $request->installment;
            $proposal->update();

            return redirect()->route('proposal.show', compact('proposal'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal) {
        $DateTime = new DateTime($proposal->date_creation);
        $DateTime->add(new \DateInterval("P" . $proposal->expiration_date . "D"));
        $proposal->expiration_date = $DateTime->format('d/m/Y');

        $proposalType = $proposal->type;

        $sumInvoices = 0;
        foreach ($proposal->invoices as $invoice) {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->sum('value');
            if ($invoice->totalPrice == $invoice->paid) {
                $invoice->status = 'paga';
            } elseif ($invoice->totalPrice > $invoice->paid AND $invoice->paid > 0) {
                $invoice->status = 'parcial';
            } elseif ($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d')) {
                $invoice->status = 'atrasada';
            }
            $sumInvoices += $invoice->totalPrice;
        }

        $productProposals = ProductProposal::where('proposal_id', $proposal->id)
                ->get();

        $totalInvoices = $proposal->invoices->count();

        $proposalPaymentsTotal = $proposal->invoices->sum('value');
        $balance = $sumInvoices - $proposalPaymentsTotal;

        $tasksOperational = Task::where('opportunity_id', $proposal->opportunity_id)
                ->where('department', '=', 'produção')
                ->with([
                    'journeys',
                    'user'
                ])
                ->get();

        $tasksOperationalHours = Journey::whereHas('task', function ($query) use ($proposal) {
                    $query->where('opportunity_id', $proposal->opportunity_id);
                    $query->where('department', '=', 'produção');
                })
                ->sum('duration');

        return view('sales.proposals.show', compact(
                        'proposalType',
                        'proposal',
                        'productProposals',
//                        'invoices',
                        'totalInvoices',
                        'proposalPaymentsTotal',
                        'balance',
                        'tasksOperational',
                        'tasksOperationalHours',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal) {
        //
    }

    // gera X faturas correspondentes ao parcelamento da proposta
    public function generateInstallment(Proposal $proposal) {
        $invoicesIdentifiers = Invoice::where('account_id', auth()->user()->account_id)
                ->pluck('identifier')
                ->toArray();

        $lastInvoice = max($invoicesIdentifiers);

//        $invoice->save();
//        $invoice->number_installment = 1;

        $counter = 1;
        while ($counter <= $proposal->installment) {
            $invoice = new Invoice();
            $invoice->identifier = $lastInvoice + $counter;

//            $invoice->opportunity_id = $invoice->opportunity_id;
            $invoice->user_id = auth()->user()->id;
            $invoice->account_id = auth()->user()->account_id;
            $invoice->contract_id = $proposal->contract_id;
            $invoice->company_id = $proposal->company_id;
            $invoice->proposal_id = $proposal->id;
            $invoice->description = $proposal->description;
//            $invoice->discount = $invoice->discount;
//            $invoice->totalHours = $invoice->totalHours;
//            $invoice->totalAmount = $invoice->totalAmount;
//            $invoice->totalCost = $invoice->totalCost;
//            $invoice->totalTax_rate = $invoice->totalTax_rate;
            $invoice->totalPrice = $proposal->totalPrice / $proposal->installment;
//            $invoice->totalMargin = $invoice->totalMargin;
//            $invoice->totalBalance = $invoice->totalBalance;
            $invoice->number_installment = $counter;
//            $invoice->number_installment_total = $invoice->number_installment_total;
//            $invoice->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
            $invoice->type = $proposal->type;
            $invoice->status = 'aprovada';

            $DateTime = new DateTime($proposal->pay_day);
            $DateTime->add(new \DateInterval("P" . $counter . "M"));
            $invoice->pay_day = $DateTime->format('Y-m-d');

            $DateTime2 = new DateTime($proposal->date_creation);
            $DateTime2->add(new \DateInterval("P" . $counter . "M"));
            $invoice->date_creation = $DateTime2->format('Y-m-d');

            $invoice->save();

            $counter++;
        }
        return redirect()->back();
    }

    // exibe as faturas correspondentes ao parcelamento da proposta
    public function editInstallment(Proposal $proposal) {
//                $proposal = Proposal::where('id', $proposal->id)
//                ->with('transactions')
//                ->orderBy('identifier', 'ASC')
//                ->get();
//                dd($proposal);
        return view('sales.proposals.editInstallment', compact(
                        'proposal'
        ));
    }

    // atualiza os valores das faturas correspondentes a uma proposta
    public function updateInstallment(Request $request, Proposal $proposal) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];

        $validator = Validator::make($request->all(), [
                    'totalPrice' => 'required:invoices',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
// soma novo total inserido para faturas
            $sumInvoicesPrice = 0;
            $counter = 0;
            foreach ($request->totalPrice as $totalPrice) {
                $totalPrice = removeCurrency($request->totalPrice[$counter]);
                $sumInvoicesPrice += $totalPrice;
                $counter++;
            }
        }

        // erro se o total inserido foir maior que o valor da proposta.
        if ($sumInvoicesPrice > $proposal->totalPrice) {
            return back()
                            ->with('failed', 'A soma das faturas NÃO pode ser maior que o total da proposta.')
//                            ->withErrors($validator)
                            ->withInput();
        } else {
//atualiza valores das faturas
            $counter = 0;
            foreach ($proposal->invoices as $invoice) {
                $invoice->totalPrice = removeCurrency($request->totalPrice[$counter]);
                $invoice->update();
                $counter++;
            }

            return redirect()->route('proposal.show', compact(
                                    'proposal'
            ));
        }
    }

    // Gera PDF da proposta
    public function createPDF(Proposal $proposal) {
        $totalTransactions = Transaction::whereHas('invoice', function ($query) use ($proposal) {
                    $query->where('proposal_id', $proposal->id);
                })
                ->sum('value');

        $proposalLines = ProductProposal::where('proposal_id', $proposal->id)
                ->with('product', 'opportunity')
                ->get();

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->where('status', 'LIKE', 'recebendo')
                ->with([
                    'account.image',
                    'bank',
                ])
                ->get();


// definição do título
        if ($proposal->status == 'orçamento' OR $proposal->status == 'rascunho') {
            $pdfTitle = 'ORÇAMENTO';
        } elseif ($proposal->status == 'aprovada' OR $proposal->status == 'paga') {
            $pdfTitle = 'FATURA';
        }

        if ($proposal->company_id) {
            $email = $proposal->company->email;
            $phone = $proposal->company->phone;
            $address = $proposal->company->address;
            $city = $proposal->company->city;
            $state = $proposal->company->state;
            $country = $proposal->company->country;
            $companyName = $proposal->company->name;
            $companyCnpj = $proposal->company->cnpj;
            $contactCpf = null;
        } else {
            $email = $proposal->contact->email;
            $phone = $proposal->contact->phone;
            $address = $proposal->contact->address;
            $city = $proposal->contact->city;
            $state = $proposal->contact->state;
            $country = $proposal->contact->country;
            $companyName = null;
            $companyCnpj = null;
            $contactCpf = $proposal->contact->cpf;
        }

        $data = [
            'pdfTitle' => $pdfTitle,
            'accountLogo' => $proposal->account->image->path,
            'accountPrincipalColor' => $proposal->account->principal_color,
            'accountComplementaryColor' => $proposal->account->complementary_color,
            'accountName' => $proposal->account->name,
            'accountEmail' => $proposal->account->email,
            'accountPhone' => $proposal->account->phone,
            'accountAddress' => $proposal->account->address,
            'accountCity' => $proposal->account->city,
            'accountState' => $proposal->account->state,
            'accountCnpj' => $proposal->account->cnpj,
            'companyName' => $companyName,
            'companyCnpj' => $companyCnpj,
            'contactCpf' => $contactCpf,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'bankAccounts' => $bankAccounts,
            'invoiceIdentifier' => $proposal->identifier,
            'invoiceDescription' => $proposal->description,
            'invoiceDiscount' => $proposal->discount,
            'invoiceExpirationDate' => $proposal->expiration_date,
            'invoiceInstallmentValue' => $proposal->installment_value,
            'invoiceStatus' => $proposal->status,
            'invoiceNumberInstallmentTotal' => $proposal->number_installment_total,
            'invoiceTotalPrice' => $proposal->installment_value,
            'opportunityDescription' => $proposal->opportunity->description,
            'invoiceDiscount' => $proposal->discount,
            'invoicePayday' => $proposal->pay_day,
            'invoiceTotalPrice' => $proposal->totalPrice,
            'customerName' => $proposal->opportunity->contact->name,
            'invoiceLines' => $proposalLines,
            'invoiceTotalTransactions' => $totalTransactions,
        ];
//        dd($data);
        $header = view('layouts/pdfHeader', compact('data'))->render();
        $footer = view('layouts/pdfFooter', compact('data'))->render();
        $pdf = PDF::loadView('financial.invoices.pdfInvoice', compact('data'))
                ->setOptions([
            'page-size' => 'A4',
            'header-html' => $header,
            'footer-html' => $footer,
        ]);

// download PDF file with download method
        return $pdf->stream('Fatura.pdf');
    }

    // Gera PDF do relatório de produção da proposta
    public function createProductionPdf(Proposal $proposal) {
        
        $totalTransactions = Transaction::whereHas('invoice', function ($query) use ($proposal) {
                    $query->where('proposal_id', $proposal->id);
                })
                ->sum('value');

//        $proposalLines = ProductProposal::where('proposal_id', $proposal->id)
//                ->with('product', 'opportunity')
//                ->get();

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->where('status', 'LIKE', 'recebendo')
                ->with([
                    'account.image',
                    'bank',
                ])
                ->get();

        $tasksOperational = Task::where('opportunity_id', $proposal->opportunity_id)
                ->where('department', '=', 'produção')
                ->with('journeys')
                ->get();

        $tasksOperationalPoints = $tasksOperational
                ->sum('points');

        $tasksOperationalPointsExecuted = $tasksOperational
                ->where('status', 'feito')
                ->sum('points');

// definição do título
        if ($proposal->status == 'orçamento' OR $proposal->status == 'rascunho') {
            $pdfTitle = 'ORÇAMENTO';
        } elseif ($proposal->status == 'aprovada' OR $proposal->status == 'paga') {
            $pdfTitle = 'FATURA';
        }

        if ($proposal->company_id) {
            $email = $proposal->company->email;
            $phone = $proposal->company->phone;
            $address = $proposal->company->address;
            $city = $proposal->company->city;
            $state = $proposal->company->state;
            $country = $proposal->company->country;
            $companyName = $proposal->company->name;
            $companyCnpj = $proposal->company->cnpj;
            $contactCpf = null;
        } else {
            $email = $proposal->contact->email;
            $phone = $proposal->contact->phone;
            $address = $proposal->contact->address;
            $city = $proposal->contact->city;
            $state = $proposal->contact->state;
            $country = $proposal->contact->country;
            $companyName = null;
            $companyCnpj = null;
            $contactCpf = $proposal->contact->cpf;
        }

        $data = [
            'pdfTitle' => $pdfTitle,
            'accountLogo' => $proposal->account->image->path,
            'accountPrincipalColor' => $proposal->account->principal_color,
            'accountComplementaryColor' => $proposal->account->complementary_color,
            'accountName' => $proposal->account->name,
            'accountEmail' => $proposal->account->email,
            'accountPhone' => $proposal->account->phone,
            'accountAddress' => $proposal->account->address,
            'accountCity' => $proposal->account->city,
            'accountState' => $proposal->account->state,
            'accountCnpj' => $proposal->account->cnpj,
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
            'bankAccounts' => $bankAccounts,
            'invoiceIdentifier' => $proposal->identifier,
            'invoiceDescription' => $proposal->description,
            'invoiceDiscount' => $proposal->discount,
            'invoiceExpirationDate' => $proposal->expiration_date,
            'invoiceInstallmentValue' => $proposal->installment_value,
            'invoiceStatus' => $proposal->status,
            'invoiceNumberInstallmentTotal' => $proposal->number_installment_total,
            'invoiceTotalPrice' => $proposal->installment_value,
            'opportunityDescription' => $proposal->opportunity->description,
            'invoiceDiscount' => $proposal->discount,
            'invoicePayday' => $proposal->pay_day,
            'invoiceTotalPrice' => $proposal->totalPrice,
            'customerName' => $proposal->opportunity->contact->name,
//            'invoiceLines' => $proposalLines,
            'invoiceTotalTransactions' => $totalTransactions,
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

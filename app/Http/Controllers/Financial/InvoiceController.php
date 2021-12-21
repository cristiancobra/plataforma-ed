<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\ProductProposal;
use App\Models\Proposal;
use App\Models\Transaction;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use DateTime;

class InvoiceController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');
        $yearStart = date('Y-01-01');
        $yearEnd = date('Y-12-31');

        $invoices = Invoice::filterInvoices($request);

        foreach ($invoices as $invoice) {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->where('trash', '!=', 1)
                    ->sum('value');
            if ($invoice->totalPrice == $invoice->paid) {
                $invoice->status = 'paga';
            } elseif ($invoice->totalPrice > $invoice->paid AND $invoice->paid > 0) {
                $invoice->status = 'parcial';
            } elseif ($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d')) {
                $invoice->status = 'atrasada';
            }

            $invoice->balance = $invoice->totalPrice - $invoice->paid;

//            $invoicesTotal += $invoice->totalPrice;
//            $proposal->balance += $invoice->balance;
        }

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();

        $total = $invoices->total();

        $estimatedRevenueMonthly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('installment_value');

        $estimatedExpenseMonthly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'despesa')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$monthStart, $monthEnd])
                ->sum('installment_value');

        $estimatedRevenueYearly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$yearStart, $yearEnd])
                ->sum('installment_value');

        $estimatedExpenseYearly = Invoice::where('account_id', auth()->user()->account_id)
                ->where('type', 'despesa')
                ->where('status', 'aprovada')
                ->whereBetween('pay_day', [$yearStart, $yearEnd])
                ->sum('installment_value');

        return view('financial.invoices.index', compact(
                        'monthStart',
                        'monthEnd',
                        'invoices',
                        'contacts',
                        'companies',
                        'users',
                        'total',
                        'estimatedRevenueMonthly',
                        'estimatedExpenseMonthly',
                        'estimatedRevenueYearly',
                        'estimatedExpenseYearly',
        ));
    }

    /**
     * Show the form for creating a new INVOICE type credit.
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

        $proposals = Proposal::where('account_id', auth()->user()->account_id)
                ->where('type', $typeInvoices)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->where('type', $typeCompanies)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
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

        $status = Proposal::returnStatus();

        return view('financial.invoices.create', compact(
                        'request',
                        'proposals',
                        'opportunities',
                        'contacts',
                        'companies',
                        'products',
                        'users',
                        'typeInvoices',
                        'status',
        ));
    }

    /**
     * Store a newly created Revenue in storage.
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
            $invoice = new Invoice();
            $invoice->fill($request->all());
//            $DateTime = new DateTime($request->date_creation);
//            $DateTime->add(new \DateInterval("P" . $request->expiration_date . "D"));
//            $invoice->expiration_date = $DateTime->format( 'd/m/Y');
//            dd($DateTime);
            $invoice->account_id = auth()->user()->account_id;

            $invoicesIdentifier = Invoice::where('account_id', $request->account_id)
                    ->pluck('identifier')
                    ->toArray();

            // Se for rascunho ou orçamento atribui ID zero
            if ($invoicesIdentifier == null) {
                $invoice->identifier = 1;
            } else {
                $invoice->identifier = max($invoicesIdentifier) + 1;
            }

            $invoice->save();

            // Cria e salva um relacionamento ProductProposal para cada PRODUTO com quantidade maior que zero
            $totalPrice = 0;
            $totalTaxrate = 0;
            foreach ($request->product_id as $key => $value) {
                if ($request->product_amount [$key] > 0) {
                    $data = array(
                        'proposal_id' => $request->proposal_id,
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
//					dd($request->product_margin [$key]);
                }
            }
            $invoice->totalPrice = $totalPrice - str_replace(",", ".", $request->discount);
            $invoice->number_installment = 1;
            $invoice->number_installment_total = $request->number_installment_total;
            $invoice->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
            $invoice->update();

            return redirect()->route('invoice.show', compact('invoice'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice) {
        $DateTime = new DateTime($invoice->date_creation);
        $DateTime->add(new \DateInterval("P" . $invoice->expiration_date . "D"));
        $invoice->expiration_date = $DateTime->format('d/m/Y');

        $typeInvoices = $invoice->type;

        $invoices = Invoice::where('opportunity_id', $invoice->opportunity_id)
                ->where('trash', '!=', 1)
                ->where('status', 'aprovada')
                ->orderBy('PAY_DAY', 'ASC')
                ->get();

        foreach ($invoices as $invoice2) {
            $invoice2->paid = Transaction::where('invoice_id', $invoice2->id)
                    ->sum('value');

            if ($invoice2->status == 'aprovada' AND $invoice2->pay_day < date('Y-m-d')) {
                $invoice2->status = 'atrasada';
            }
        }

        $productProposals = ProductProposal::where('proposal_id', $invoice->proposal_id)
                ->get();

        $totalInvoices = $invoices->count();

        $transactions = Transaction::where('invoice_id', $invoice->id)
                ->where('trash', '!=', 1)
                ->get();

        $invoicePaymentsTotal = $transactions->sum('value');
        $balance = $invoice->totalPrice - $invoicePaymentsTotal;

        $variation = $invoice->type;

        return view('financial.invoices.show', compact(
                        'typeInvoices',
                        'invoice',
                        'invoices',
                        'productProposals',
                        'totalInvoices',
                        'transactions',
                        'invoicePaymentsTotal',
                        'balance',
                        'variation',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice) {
        $users = User::myUsers();

        $opportunities = Opportunity::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $products = Product::where('account_id', auth()->user()->account_id)
                ->where('type', 'receita')
                ->where('status', 'disponível')
                ->orderBy('NAME', 'ASC')
                ->get();

        $productsChecked = Invoice::find($invoice->id);

        $productProposals = ProductProposal::where('proposal_id', $invoice->proposal_id)
                ->get();

        $contracts = Contract::where('proposal_id', $invoice->proposal_id)
                ->orderBy('ID', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $variation = $invoice->type;

        $status = Proposal::returnStatus();

        return view('financial.invoices.edit', compact(
                        'invoice',
                        'productProposals',
                        'users',
                        'opportunities',
                        'companies',
                        'products',
                        'productsChecked',
                        'contracts',
                        'contacts',
                        'variation',
                        'status',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice) {
        $messages = [
            'required' => '*preenchimento obrigatório.',
        ];

        $validator = Validator::make($request->all(), [
                    'pay_day' => 'required:invoices',
                    'date_creation' => 'required:invoices',
                        ],
                        $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $invoice->fill($request->all());
            if ($invoice->type == 'receita') {
                $totalPrice = removeCurrency($request->totalPrice);
            } else {
                $totalPrice = removeCurrency($request->totalPrice) * -1;
            }
            $invoice->totalPrice = $totalPrice;
            $invoice->save();

            return redirect()->route('invoice.show', compact('invoice'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice) {
        $invoice->invoiceLines()->delete();
        $invoice->delete();

        return redirect()->action('Financial\\InvoiceController@index');
    }

// Gera PDF da fatura
    public function createPdf(Invoice $invoice) {
//        dd($invoice->proposal);
        $totalTransactions = Transaction::whereHas('invoice', function ($query) use ($invoice) {
                    $query->where('invoice_id', $invoice->id);
                })
                ->sum('value');

        $productProposals = ProductProposal::where('proposal_id', $invoice->proposal_id)
                ->get();

        $bankAccounts = BankAccount::where('account_id', auth()->user()->account_id)
                ->where('status', 'LIKE', 'recebendo')
                ->with([
                    'account.image',
                    'bank',
                ])
                ->get();

        $tasksOperational = Task::where('opportunity_id', $invoice->opportunity_id)
                ->where('department', '=', 'produção')
                ->with('journeys')
                ->get();

        $tasksOperationalPoints = $tasksOperational
                ->sum('points');

        $tasksOperationalPointsExecuted = $tasksOperational
                ->where('status', 'feito')
                ->sum('points');

        if ($invoice->proposal->opportunity) {
            $opportunityDescription = $invoice->proposal->opportunity->description;
        } else {
            $opportunityDescription = 'Não possui';
        }

        if ($invoice->proposal->contact) {
            $customerName = $invoice->proposal->contact->name;
        } else {
            $customerName = 'Não possui';
        }

// definição do título
        if ($invoice->status == 'orçamento' OR $invoice->status == 'rascunho') {
            $pdfTitle = 'ORÇAMENTO';
        } elseif ($invoice->status == 'aprovada' OR $invoice->status == 'paga') {
            $pdfTitle = 'FATURA';
        }

        if ($invoice->company_id) {
            $email = $invoice->company->email;
            $phone = $invoice->company->phone;
            $address = $invoice->company->address;
            $city = $invoice->company->city;
            $state = $invoice->company->state;
            $country = $invoice->company->country;
            $companyName = $invoice->company->name;
            $companyCnpj = $invoice->company->cnpj;
            $contactCpf = null;
        } else {
            $email = $invoice->contact->email;
            $phone = $invoice->contact->phone;
            $address = $invoice->contact->address;
            $city = $invoice->contact->city;
            $state = $invoice->contact->state;
            $country = $invoice->contact->country;
            $companyName = null;
            $companyCnpj = null;
            $contactCpf = $invoice->contact->cpf;
        }

        $data = [
            'pdfTitle' => $pdfTitle,
            'accountLogo' => $invoice->account->image->path,
            'accountPrincipalColor' => $invoice->account->principal_color,
            'accountComplementaryColor' => $invoice->account->complementary_color,
            'accountName' => $invoice->account->name,
            'accountEmail' => $invoice->account->email,
            'accountPhone' => $invoice->account->phone,
            'accountAddress' => $invoice->account->address,
            'accountCity' => $invoice->account->city,
            'accountState' => $invoice->account->state,
            'accountCnpj' => $invoice->account->cnpj,
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
            'invoiceIdentifier' => $invoice->identifier,
            'invoiceDescription' => $invoice->description,
            'invoiceDiscount' => $invoice->discount,
            'invoiceExpirationDate' => $invoice->expiration_date,
            'invoiceInstallmentValue' => $invoice->installment_value,
            'invoiceStatus' => $invoice->status,
            'invoiceNumberInstallmentTotal' => $invoice->number_installment_total,
            'invoiceTotalPrice' => $invoice->installment_value,
//            'opportunityDescription' => $invoice->proposal->opportunity->description,
            'opportunityDescription' => $opportunityDescription,
            'invoiceDiscount' => $invoice->discount,
            'invoicePayday' => $invoice->pay_day,
            'invoiceTotalPrice' => $invoice->totalPrice,
            'customerName' => $customerName,
            'productProposals' => $productProposals,
            'invoiceTotalTransactions' => $totalTransactions,
//            'tasksOperational' => $tasksOperational,
//            'tasksOperationalPoints' => $tasksOperationalPoints,
//            'tasksOperationalPointsExecuted' => $tasksOperationalPointsExecuted,
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

// Gera PDF de relatório
    public function createPdfReport() {
        $months = returnMonths();
        $pastMonths = date('m');

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

//   RECEITAS
        $monthlyRevenues = Invoice::monthlyInvoicesTotal($year, 'receita');
        $annualRevenues = Invoice::annualInvoicesTotal($year, 'receita');

        $categoriesNames = Product::returnCategories();
        $categories = [];
        foreach ($categoriesNames as $category) {
            $categories[$category]['name'] = $category;
            $categories[$category]['monthlys'] = Invoice::monthlysCategoriesTotal($year, $category, 'receita');
            $categories[$category]['year'] = Invoice::annualCategoriesTotal($year, $category, 'receita');
        }

        // DESPESAS
        $monthlyExpenses = Invoice::monthlyInvoicesTotal($year, 'despesa');
        $annualExpenses = Invoice::annualInvoicesTotal($year, 'despesa');

        $groupsName = Product::returnGroups();
        $groups = [];
        foreach ($groupsName as $group) {
            $groups[$group]['name'] = $group;
            $groups[$group]['monthlys'] = Invoice::monthlysGroupsTotal($year, $group, 'despesa');
            $groups[$group]['year'] = Invoice::annualGroupsTotal($year, $group, 'despesa');
        }

        // Gráfico
        $chartBackgroundColors = [
            'rgba(255, 206, 86, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(41, 221, 101, 0.2)',
            'rgba(255, 99, 132, 0.2)',
        ];

        $chartBorderColors = [
            'rgba(255, 206, 86, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(41, 221, 101, 1)',
            'rgba(255, 99, 132, 1)',
        ];

// definição do título
//        if ($invoice->status == 'orçamento' OR $invoice->status == 'rascunho') {
//            $pdfTitle = 'ORÇAMENTO';
//        } elseif ($invoice->status == 'aprovada' OR $invoice->status == 'paga') {
//            $pdfTitle = 'FATURA';
//        }
//        if ($invoice->company_id) {
//            $email = $invoice->company->email;
//            $phone = $invoice->company->phone;
//            $address = $invoice->company->address;
//            $city = $invoice->company->city;
//            $state = $invoice->company->state;
//            $country = $invoice->company->country;
//            $companyName = $invoice->company->name;
//            $companyCnpj = $invoice->company->cnpj;
//            $contactCpf = null;
//        } else {
//            $email = $invoice->contact->email;
//            $phone = $invoice->contact->phone;
//            $address = $invoice->contact->address;
//            $city = $invoice->contact->city;
//            $state = $invoice->contact->state;
//            $country = $invoice->contact->country;
//            $companyName = null;
//            $companyCnpj = null;
//            $contactCpf = $invoice->contact->cpf;
//        }

        $account = auth()->user()->account;

        $data = [
            'pdfTitle' => 'RELATÓRIO FINANCEIRO',
            'accountLogo' => $account->image->path,
            'accountPrincipalColor' => $account->principal_color,
            'accountComplementaryColor' => $account->complementary_color,
            'accountName' => $account->name,
            'accountEmail' => $account->email,
            'accountPhone' => $account->phone,
            'accountAddress' => $account->address,
            'accountCity' => $account->city,
            'accountState' => $account->state,
            'accountCnpj' => $account->cnpj,
//            'taskDescription' => $task->description,
//            'customerName' => $task->contact->name,
//            'companyName' => $companyName,
//            'companyCnpj' => $companyCnpj,
//            'contactCpf' => $contactCpf,
//            'email' => $email,
//            'phone' => $phone,
//            'address' => $address,
//            'city' => $city,
//            'state' => $state,
//            'country' => $country,
//            'bankAccounts' => $bankAccounts,
//            'invoiceIdentifier' => $invoice->identifier,
//            'invoiceDescription' => $invoice->description,
//            'invoiceDiscount' => $invoice->discount,
//            'invoiceExpirationDate' => $invoice->expiration_date,
//            'invoiceInstallmentValue' => $invoice->installment_value,
//            'invoiceStatus' => $invoice->status,
//            'invoiceNumberInstallmentTotal' => $invoice->number_installment_total,
//            'invoiceTotalPrice' => $invoice->installment_value,
//            'opportunityDescription' => $invoice->proposal->opportunity->description,
//            'invoiceDiscount' => $invoice->discount,
//            'invoicePayday' => $invoice->pay_day,
//            'invoiceTotalPrice' => $invoice->totalPrice,
//            'customerName' => $invoice->proposal->opportunity->contact->name,
//            'invoiceLines' => $invoiceLines,
//            'invoiceTotalTransactions' => $totalTransactions,
//            'tasksOperational' => $tasksOperational,
//            'tasksOperationalPoints' => $tasksOperationalPoints,
//            'tasksOperationalPointsExecuted' => $tasksOperationalPointsExecuted,
            'months' => $months,
            'monthlyRevenues' => $monthlyRevenues,
            'annualRevenues' => $annualRevenues,
            'categories' => $categories,
            'monthlyExpenses' => $monthlyExpenses,
            'annualExpenses' => $annualExpenses,
            'groups' => $groups,
        ];
//        dd($data);
        $header = view('layouts/pdfHeader', compact('data'))->render();
        $footer = view('layouts/pdfFooter', compact('data'))->render();
        $pdf = PDF::loadView('financial.invoices.reportPdf', compact('data'))
                ->setOptions([
            'page-size' => 'A4',
            'orientation' => 'Landscape',
            'header-html' => $header,
            'footer-html' => $footer,
                ])
        ;

// download PDF file with download method
        return $pdf->stream('Relatório financeiro.pdf');
    }

    public function sendToTrash(Invoice $invoice) {
        $invoice->trash = 1;
        $invoice->save();

        return redirect()->back();
    }


    public function restoreFromTrash(Invoice $invoice) {
        $invoice->trash = 0;
        $invoice->save();

        return redirect()->back();
    }

    public function report(Request $request) {
        $months = returnMonths();
        $pastMonths = date('m');

        if (isset($request->year)) {
            $year = $request->year;
        } else {
            $year = date('y');
        }

//   RECEITAS
        $monthlyRevenues = Invoice::monthlyInvoicesTotal($year, 'receita');
        $annualRevenues = Invoice::annualInvoicesTotal($year, 'receita');

        $categoriesNames = Product::returnCategories();
        $categories = [];
        foreach ($categoriesNames as $category) {
            $categories[$category]['name'] = $category;
            $categories[$category]['monthlys'] = Invoice::monthlysCategoriesTotal($year, $category, 'receita');
            $categories[$category]['year'] = Invoice::annualCategoriesTotal($year, $category, 'receita');
        }

        // DESPESAS
        $monthlyExpenses = Invoice::monthlyInvoicesTotal($year, 'despesa');
        $annualExpenses = Invoice::annualInvoicesTotal($year, 'despesa');

        $groupsName = Product::returnGroups();
        $groups = [];
        foreach ($groupsName as $group) {
            $groups[$group]['name'] = $group;
            $groups[$group]['monthlys'] = Invoice::monthlysGroupsTotal($year, $group, 'despesa');
            $groups[$group]['year'] = Invoice::annualGroupsTotal($year, $group, 'despesa');
        }

        // Gráfico
        $chartBackgroundColors = [
            'rgba(255, 206, 86, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(41, 221, 101, 0.2)',
            'rgba(255, 99, 132, 0.2)',
        ];

        $chartBorderColors = [
            'rgba(255, 206, 86, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(41, 221, 101, 1)',
            'rgba(255, 99, 132, 1)',
        ];

        return view('financial.invoices.report', compact(
                        'year',
                        'months',
                        'monthlyRevenues',
                        'categories',
                        'categoriesNames',
                        'groups',
                        'annualRevenues',
                        'monthlyExpenses',
                        'annualExpenses',
                        'chartBackgroundColors',
                        'chartBorderColors',
        ));
    }

}

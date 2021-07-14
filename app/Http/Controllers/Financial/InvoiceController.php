<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\BankAccount;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Journey;
use App\Models\Opportunity;
use App\Models\Product;
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
        $invoices = $this->filterInvoices($request);
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');
        $yearStart = date('Y-01-01');
        $yearEnd = date('Y-12-31');
//
//        $invoices = Invoice::where('account_id', auth()->user()->account_id)
//                ->with([
//                    'account',
//                    'opportunity',
//                    'invoiceLines.product',
//                    'account.bankAccounts',
//                    'user.contact',
//                    'contract',
//                ])
//                ->orderBy('pay_day', 'DESC')
//                ->paginate(20);
//        $invoices->appends([
//            'status' => $request->status,
//            'contact_id' => $request->contact_id,
//            'user_id' => $request->user_id,
//        ]);
//        foreach ($invoices as $invoice) {
//            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
//                    ->sum('value');
//
//            if ($invoice->paid >= $invoice->installment_value) {
//                $invoice->status = 'paga';
//            } elseif ($invoice->paid > 0 AND $invoice->paid <= $invoice->installment_value) {
//                $invoice->status = 'parcial';
//            }
//        }

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

        return view('financial.invoices.indexInvoices', compact(
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

        return view('financial.invoices.createInvoice', compact(
                        'request',
                        'opportunities',
                        'contacts',
                        'companies',
                        'products',
                        'users',
                        'typeInvoices',
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
            if ($request->status == 'rascunho' OR $request->status == 'orçamento') {
                $invoice->identifier = 0;
            } elseif ($invoicesIdentifier == null) {
                $invoice->identifier = 1;
            } else {
                $invoice->identifier = max($invoicesIdentifier) + 1;
            }

            $invoice->save();

            // Cria e salva uma InvoiceLine para cada PRODUTO com quantidade maior que zero
            $totalPrice = 0;
            $totalTaxrate = 0;
            foreach ($request->product_id as $key => $value) {
                if ($request->product_amount [$key] > 0) {
                    $data = array(
                        'invoice_id' => $invoice->id,
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
                    invoiceLine::insert($data);
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

        $invoiceLines = InvoiceLine::whereHas('invoice', function ($query) use ($invoice) {
                    $query->where('invoice_id', $invoice->id);
                })
                ->get();

        $totalInvoices = $invoices->count();

        $transactions = Transaction::where('invoice_id', $invoice->id)
                ->get();

        $invoicePaymentsTotal = $transactions->sum('value');
        $balance = $invoice->totalPrice - $invoicePaymentsTotal;

        $tasksOperational = Task::where('opportunity_id', $invoice->opportunity_id)
                ->where('department', '=', 'produção')
                ->with('journeys')
                ->get();

        $tasksOperationalHours = Journey::whereHas('task', function ($query) use ($invoice) {
                    $query->where('opportunity_id', $invoice->opportunity_id);
                    $query->where('department', '=', 'produção');
                })
                ->sum('duration');
//dd($invoice);
        return view('financial.invoices.showInvoice', compact(
                        'typeInvoices',
                        'invoice',
                        'invoices',
                        'invoiceLines',
                        'totalInvoices',
                        'transactions',
                        'invoicePaymentsTotal',
                        'balance',
                        'tasksOperational',
                        'tasksOperationalHours',
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

        $invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
                ->get();

        $contracts = Contract::where('invoice_id', $invoice->id)
                ->orderBy('ID', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $variation = $invoice->type;

        return view('financial.invoices.editInvoice', compact(
                        'invoice',
                        'invoiceLines',
                        'users',
                        'opportunities',
                        'companies',
                        'products',
                        'productsChecked',
                        'contracts',
                        'contacts',
                        'variation',
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
//        dd($request);
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
            // se for aprovada pega o ultimo IDENTIFIER e soma 1, senão atribui 0
            $lastInvoice = Invoice::where('account_id', $invoice->account_id)
                    ->latest('id')
                    ->first();

            if ($invoice->identifier == 0 AND $request->status == "aprovada" OR $request->status == "paga") {
                if ($lastInvoice->identifier > 0) {
                    $invoice->identifier = $lastInvoice->identifier + 1;
                } else {
                    $invoice->identifier = 1;
                }
            }
            $invoiceStatus = $invoice->status;
            $invoice->fill($request->all());
            $invoice->discount = str_replace(",", ".", $request->discount);
            $invoice->save();

            // atualiza produtos que JÁ EXISTEM na fatura se o status for RASCUNHO ou ESBOÇO
            $totalPoints = 0;
            $totalPrice = 0;
            $totalTaxrate = 0;
            $products = $request['product_id'];
//            if ($invoiceStatus == "rascunho" OR $invoice->status == "orçamento") {
            if (isset($products)) {
                foreach ($products as $key => $id) {
                    $data = array(
                        'id' => $request->invoiceLine_id[$key],
                        'invoice_id' => $invoice->id,
                        'product_id' => $request->product_id[$key],
                        'amount' => $request->product_amount[$key],
                        'subtotalHours' => $request->product_amount[$key] * $request->product_work_hours[$key],
                        'subtotalDeadline' => $request->product_amount[$key] * $request->product_due_date[$key],
                        'subtotalCost' => $request->product_amount[$key] * $request->product_cost[$key],
                        'subtotalTax_rate' => $request->product_amount[$key] * $request->product_tax_rate[$key],
                        'subtotalMargin' => $request->product_amount[$key] * $request->product_margin[$key],
                        'subtotalPoints' => $request->product_amount[$key] * $request->product_points[$key],
                        'subtotalPrice' => $request->product_amount[$key] * removeCurrency($request->product_price [$key]),
                    );
                    $totalPoints = $totalPoints + $data['subtotalPoints'];
                    $totalPrice = $totalPrice + $data['subtotalPrice'];
                    $totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
                    if ($request->product_amount[$key] <= 0) {
                        invoiceLine::where('id', $request->invoiceLine_id)->delete();
                    } else {
                        invoiceLine::where('id', $request->invoiceLine_id[$key])->update($data);
                    }
                }
            }
            // adiciona NOVOS produtos na fatura  se o status for RASCUNHO ou ESBOÇO
            $newTotalPoints = 0;
            $newTotalPrice = 0;
            $newProducts = $request['new_product_id'];

            foreach ($newProducts as $key => $newProductId) {
                if ($request->new_product_amount[$key] > 0) {
                    $data = array(
                        'invoice_id' => $invoice->id,
                        'product_id' => $request->new_product_id [$key],
                        'amount' => $request->new_product_amount [$key],
                        'subtotalHours' => $request->new_product_amount [$key] * $request->new_product_work_hours [$key],
                        'subtotalDeadline' => $request->new_product_amount [$key] * $request->new_product_due_date [$key],
                        'subtotalCost' => $request->new_product_amount [$key] * $request->new_product_cost [$key],
                        'subtotalTax_rate' => $request->new_product_amount [$key] * $request->new_product_tax_rate [$key],
                        'subtotalMargin' => $request->new_product_amount [$key] * $request->new_product_margin [$key],
                        'subtotalPoints' => $request->new_product_amount [$key] * $request->new_product_points[$key],
                        'subtotalPrice' => $request->new_product_amount [$key] * removeCurrency($request->new_product_price [$key]),
                    );
                    $newTotalPoints = $newTotalPoints + $data['subtotalPoints'];
                    $newTotalPrice = $newTotalPrice + $data['subtotalPrice'];
                    $totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
                    invoiceLine::insert($data);
                }
            }
            $invoice->totalPoints = $totalPoints + $newTotalPoints;
            $invoice->totalPrice = $totalPrice + $newTotalPrice - str_replace(",", ".", $request->discount);
//            if ($request->installment_value) {
                $invoice->installment_value = $request->installment_value;
//            } else {
//                $invoice->installment_value = $invoice->totalPrice / $request->number_installment_total;
//            }
            $invoice->number_installment_total = $request->number_installment_total;
            $invoice->save();

            return redirect()->route('invoice.show', compact('invoice',
            ));
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
    public function createPDF(Invoice $invoice) {
        $totalTransactions = Transaction::whereHas('invoice', function ($query) use ($invoice) {
                    $query->where('invoice_id', $invoice->id);
                })
                ->sum('value');

        $invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
                ->with('product', 'opportunity')
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
            'opportunityDescription' => $invoice->opportunity->description,
            'invoiceDiscount' => $invoice->discount,
            'invoicePayday' => $invoice->pay_day,
            'invoiceTotalPrice' => $invoice->totalPrice,
            'customerName' => $invoice->opportunity->contact->name,
            'invoiceLines' => $invoiceLines,
            'invoiceTotalTransactions' => $totalTransactions,
//            'tasksOperational' => $tasksOperational,
//            'tasksOperationalPoints' => $tasksOperationalPoints,
//            'tasksOperationalPointsExecuted' => $tasksOperationalPointsExecuted,
        ];
        dd($data);
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

// Generate parcelamento a partir de uma fatura já criada
    public function generateInstallment(Invoice $invoice) {
        $invoices = Invoice::where('account_id', $invoice->account_id)
                ->pluck('identifier')
                ->toArray();

        $lastInvoice = max($invoices);
        if ($invoice->identifier == 0) {
            $invoice->identifier = $lastInvoice + 1;
        }
        $invoice->number_installment = 1;
        $invoice->save();

        $invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
                ->with('product')
                ->get();

        $counter = 1;
        while ($counter <= $invoice->number_installment_total - 1) {
            $invoiceNew = new Invoice();
            $invoiceNew->identifier = $lastInvoice + $counter;

            $invoiceNew->opportunity_id = $invoice->opportunity_id;
            $invoiceNew->user_id = $invoice->user_id;
            $invoiceNew->account_id = $invoice->account_id;
            $invoiceNew->contract_id = $invoice->contract_id;
            $invoiceNew->company_id = $invoice->company_id;
            $invoiceNew->date_creation = $invoice->date_creation;
            $invoiceNew->pay_day = date("Y-m-d", strtotime("+" . ($counter) . " month", strtotime($invoice->pay_day)));
            $invoiceNew->description = $invoice->description;
            $invoiceNew->discount = $invoice->discount;
            $invoiceNew->totalHours = $invoice->totalHours;
            $invoiceNew->totalAmount = $invoice->totalAmount;
            $invoiceNew->totalCost = $invoice->totalCost;
            $invoiceNew->totalTax_rate = $invoice->totalTax_rate;
            $invoiceNew->totalPrice = $invoice->totalPrice;
            $invoiceNew->totalMargin = $invoice->totalMargin;
            $invoiceNew->totalBalance = $invoice->totalBalance;
            $invoiceNew->number_installment = $counter + 1;
            $invoiceNew->number_installment_total = $invoice->number_installment_total;
            $invoiceNew->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
            $invoiceNew->type = $invoice->type;
            $invoiceNew->status = 'aprovada';
            $invoiceNew->save();

//			foreach ($invoiceLines as $invoiceLine) {
//				$data = array(
//					'invoice_id' => $invoice->id + $counter,
//					'product_id' => $invoiceLine->product_id,
//					'amount' => $invoiceLine->amount,
//					'subtotalHours' => $invoiceLine->subtotalHours,
//					'subtotalDeadline' => $invoiceLine->subtotalDeadline,
//					'subtotalCost' => $invoiceLine->subtotalCost,
//					'subtotalTax_rate' => $invoiceLine->subtotalTax_rate,
//					'subtotalMargin' => $invoiceLine->subtotalMargin,
//					'subtotalPrice' => $invoiceLine->subtotalPrice,
//				);
//				invoiceLine::insert($data);
//			}
            $counter++;
        }
        return redirect()->back();
    }

    public function filterInvoices(Request $request) {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');
        $yearStart = date('Y-01-01');
        $yearEnd = date('Y-12-31');

        $invoices = Invoice::where(function ($query) use ($request) {
                    $query->where('account_id', auth()->user()->account_id);
                    if ($request->name) {
                        $query->whereHas('opportunity', function ($query) use ($request) {
                            $query->where('name', 'like', "%$request->name%");
                        });
                    }
                    if ($request->date_start) {
                        $query->where('pay_day', '>', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->where('pay_day', '<', $request->date_end);
                    }
                    if ($request->company_id) {
                        $query->where('company_id', $request->company_id);
                    }
                    if ($request->contact_id) {
                        $query->where('contact_id', $request->contact_id);
                    }
                    if ($request->status) {
                        $query->where('status', '=', $request->status);
                    }
                    if ($request->type) {
                        $query->where('type', '=', $request->type);
                    }
                    if ($request->trash == 1) {
                        $query->where('trash', 1);
                    } else {
                        $query->where('trash', '!=', 1);
                    }
                })
                ->with([
                    'account',
                    'opportunity',
                    'invoiceLines.product',
                    'account.bankAccounts',
                    'user.contact',
                    'contract',
                ])
                ->orderBy('pay_day', 'DESC')
                ->paginate(20);

        $invoices->appends([
            'status' => $request->status,
            'contact_id' => $request->contact_id,
            'user_id' => $request->user_id,
        ]);

        foreach ($invoices as $invoice) {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->sum('value');
        }

        return $invoices;

//        $contacts = Contact::where('account_id', auth()->user()->account_id)
//                ->orderBy('NAME', 'ASC')
//                ->get();
//
//        $companies = Company::where('account_id', auth()->user()->account_id)
//                ->orderBy('NAME', 'ASC')
//                ->get();
//
//        $users = User::myUsers();
//
//        $total = $invoices->total();
//
//        $estimatedRevenueMonthly = Invoice::where('account_id', auth()->user()->account_id)
//                ->where('type', 'receita')
//                ->where('status', 'aprovada')
//                ->whereBetween('pay_day', [$monthStart, $monthEnd])
//                ->sum('installment_value');
//
//        $estimatedExpenseMonthly = Invoice::where('account_id', auth()->user()->account_id)
//                ->where('type', 'despesa')
//                ->where('status', 'aprovada')
//                ->whereBetween('pay_day', [$monthStart, $monthEnd])
//                ->sum('installment_value');
//
//        $estimatedRevenueYearly = Invoice::where('account_id', auth()->user()->account_id)
//                ->where('type', 'receita')
//                ->where('status', 'aprovada')
//                ->whereBetween('pay_day', [$yearStart, $yearEnd])
//                ->sum('installment_value');
//
//        $estimatedExpenseYearly = Invoice::where('account_id', auth()->user()->account_id)
//                ->where('type', 'despesa')
//                ->where('status', 'aprovada')
//                ->whereBetween('pay_day', [$yearStart, $yearEnd])
//                ->sum('installment_value');
//
//        return view('financial.invoices.indexInvoices', compact(
//                        'invoices',
//                        'companies',
//                        'contacts',
//                        'users',
//                        'total',
//                        'estimatedRevenueMonthly',
//                        'estimatedExpenseMonthly',
//                        'estimatedRevenueYearly',
//                        'estimatedExpenseYearly',
//        ));
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

}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Contact;
use App\Models\Contract;
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
    public function index(Request $request) {
        $type = $request->type;

        $proposals = Proposal::filterProposals($request);

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $users = User::myUsers();
        $types = Proposal::returnTypes();
        $trashStatus = request()->trash;

        $total = $proposals->total();

        return view('sales.proposals.index', compact(
                        'proposals',
                        'contacts',
                        'companies',
                        'users',
                        'types',
                        'total',
                        'type',
                        'trashStatus',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $type = $request->type;

        if ($type == 'receita') {
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
                ->where('type', 'LIKE', $type)
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
                        'type',
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
                    if ($request->type == 'despesa') {
                        $data['subtotalPrice'] = $data['subtotalPrice'] * -1;
                    }
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
    public function show(Proposal $proposal, Request $request) {
        $DateTime = new DateTime($proposal->date_creation);
        $DateTime->add(new \DateInterval("P" . $proposal->expiration_date . "D"));
        $proposal->expiration_date = $DateTime->format('d/m/Y');

        if ($request->type) {
            $type = $request->type;
        } else {
            $type = $proposal->type;
        }

        if ($type == 'receita') {
            $opportunityName = $proposal->opportunity->name;
            $opportunityId = $proposal->opportunity->id;
            $itensName = ' ITENS DA PROPOSTA';
        } else {
            $opportunityName = null;
            $opportunityId = null;
            $itensName = ' ITENS DA DESPESA';
        }

        $invoices = Invoice::where('account_id', auth()->user()->account_id)
                ->where('proposal_id', $proposal->id)
                ->where('trash', '!=', 1)
                ->get();

        $invoicesTotal = 0;
        $balanceTotal = 0;
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

            $invoicesTotal += $invoice->totalPrice;
            $balanceTotal += $invoice->balance;
        }

        $productProposals = ProductProposal::where('proposal_id', $proposal->id)
                ->get();

        $invoicesCount = $invoices->count();

//        $proposalPaymentsTotal = $proposal->invoices->balance->sum('value');
//        $balanceTotal = $invoicesTotal - $proposalPaymentsTotal;

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
                        'proposal',
                        'type',
                        'opportunityName',
                        'opportunityId',
                        'itensName',
                        'invoices',
                        'productProposals',
                        'invoicesCount',
                        'invoicesTotal',
                        'balanceTotal',
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
    public function edit(Proposal $proposal, Request $request) {
        $users = User::myUsers();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $contracts = Contract::where('invoice_id', $proposal->id)
                ->orderBy('ID', 'ASC')
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $productProposals = ProductProposal::where('proposal_id', $proposal->id)
                ->get();

        $type = $request->type;

        return view('sales.proposals.edit', compact(
                        'users',
                        'companies',
                        'contracts',
                        'contacts',
                        'type',
                        'proposal',
                        'productProposals',
//                        'invoices',
//                        'totalInvoices',
//                        'proposalPaymentsTotal',
//                        'balance',
//                        'tasksOperational',
//                        'tasksOperationalHours',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal) {
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
//dd($request);
            // Cria e salva uma InvoiceLine para cada PRODUTO com quantidade maior que zero
            $totalPrice = 0;
            $totalTaxrate = 0;
            foreach ($request->product_id as $key => $value) {
                if ($request->product_amount [$key] > 0) {
                    $data = array(
                        'proposal_id' => $proposal->id,
                        'product_id' => $request->product_id [$key],
                        'amount' => $request->product_amount [$key],
                        'price' => removeCurrency($request->price [$key]),
                        'subtotalHours' => $request->product_amount [$key] * $request->product_work_hours [$key],
                        'subtotalDeadline' => $request->product_amount [$key] * $request->product_due_date [$key],
                        'subtotalCost' => $request->product_amount [$key] * $request->product_cost [$key],
                        'subtotalTax_rate' => $request->product_amount [$key] * $request->product_tax_rate [$key],
                        'subtotalMargin' => $request->product_amount [$key] * $request->product_margin [$key],
                        'subtotalPrice' => $request->product_amount [$key] * removeCurrency($request->price [$key]),
                    );
                    if ($proposal->type == 'despesa') {
                    $data['price'] = $data['price'] * -1;
                    $data['subtotalPrice'] = $data['subtotalPrice'] * -1;
                    }
                    $totalPrice = $totalPrice + $data['subtotalPrice'];
                    $totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
                    ProductProposal::where('id', $request->product_proposal_id[$key])->update($data);
                }
            }
            $proposal->fill($request->all());
                
            if ($proposal->discount == null) {
                $proposal->discount = 0;
            } elseif ($proposal->type == 'despesa') {
                $proposal->discount = removeCurrency($request->discount);
            } elseif ($proposal->type == 'receita') {
                $proposal->discount = removeCurrency($request->discount);
                $proposal->discount = $proposal->discount * -1;
            }
//            if ($request->type == 'despesa') {
//                $data['subtotalPrice'] = $data['subtotalPrice'] * -1;
//            }
            $proposal->totalPrice = $totalPrice + $proposal->discount;
            $proposal->save();

            return redirect()->route('proposal.show', compact('proposal'));
        }
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

    public function sendToTrash(Proposal $proposal) {
        $proposal->trash = 1;
        $proposal->save();

        return redirect()->back();
    }

    public function restoreFromTrash(Proposal $proposal) {
        $proposal->trash = 0;
        $proposal->save();

        return redirect()->back();
    }

    // gera X faturas correspondentes ao parcelamento da proposta
    public function generateInstallment(Proposal $proposal) {
        $invoicesIdentifiers = Invoice::where('account_id', auth()->user()->account_id)
                ->pluck('identifier')
                ->toArray();

        $lastInvoice = max($invoicesIdentifiers);

        $counter = 1;
        $counterMonth = 0;
        while ($counter <= $proposal->installment) {
            $invoice = new Invoice();
            $invoice->identifier = $lastInvoice + $counter;

//            $invoice->opportunity_id = $invoice->opportunity_id;
            $invoice->user_id = auth()->user()->id;
            $invoice->account_id = auth()->user()->account_id;
            $invoice->contact_id = $proposal->contact_id;
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
            $DateTime->add(new \DateInterval("P" . $counterMonth . "M"));
            $invoice->pay_day = $DateTime->format('Y-m-d');

            $DateTime2 = new DateTime($proposal->date_creation);
            $DateTime2->add(new \DateInterval("P" . $counterMonth . "M"));
            $invoice->date_creation = $DateTime2->format('Y-m-d');

            $invoice->save();

            $counter++;
            $counterMonth++;
        }
        return redirect()->back();
    }

    // exibe as faturas correspondentes ao parcelamento da proposta
    public function editInstallment(Proposal $proposal) {
        $invoices = Invoice::where('proposal_id', $proposal->id)
                ->where('status', 'aprovada')
                ->where('trash', '!=', 1)
                ->get();

        return view('sales.proposals.editInstallment', compact(
                        'proposal',
                        'invoices',
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
            $invoices = Invoice::where('proposal_id', $proposal->id)
                    ->where('status', 'aprovada')
                    ->where('trash', '!=', 1)
                    ->get();

            $counter = 0;
            foreach ($invoices as $invoice) {
                $invoice->totalPrice = removeCurrency($request->totalPrice[$counter]);
                $invoice->pay_day = $request->pay_day[$counter];
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

}

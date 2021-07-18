<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
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
//            $DateTime = new DateTime($request->date_creation);
//            $DateTime->add(new \DateInterval("P" . $request->expiration_date . "D"));
//            $invoice->expiration_date = $DateTime->format( 'd/m/Y');
//            dd($DateTime);
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
//					dd($request->product_margin [$key]);
                }
            }
            $proposal->totalPrice = $totalPrice - str_replace(",", ".", $request->discount);
            $proposal->installment = $request->installment;
//            $proposal->number_installment_total = $request->number_installment_total;
//            $proposal->installment_value = $proposal->totalPrice / $proposal->number_installment_total;
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

        $invoices = Invoice::where('proposal_id', $proposal->id)
                ->with('transactions')
                ->orderBy('identifier', 'ASC')
                ->get();

        foreach ($invoices as $invoice) {
            $invoice->paid = Transaction::where('invoice_id', $invoice->id)
                    ->sum('value');
            if ($invoice->totalPrice == $invoice->paid) {
                $invoice->status = 'paga';
            }elseif($invoice->totalPrice > $invoice->paid AND $invoice->paid > 0) {
                $invoice->status = 'parcial';
            }elseif ($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d')) {
                $invoice->status = 'atrasada';
            }
//dd($invoice->status);
        }

        $productProposals = ProductProposal::where('proposal_id', $proposal->id)
                ->get();

        $totalInvoices = $invoices->count();

        $proposalPaymentsTotal = $invoices->sum('value');
        $balance = $proposal->totalPrice - $proposalPaymentsTotal;

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
                        'invoices',
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
//            $invoice->date_creation = $invoice->date_creation;
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
//            $invoice->pay_day = date("Y-m-d", strtotime("+" . ($counter) . " month", strtotime($invoice->pay_day)));
            
            $invoice->save();

            $counter++;
        }
        return redirect()->back();
    }

}

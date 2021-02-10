<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Account;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;

class InvoiceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$accountsId = userAccounts();

		$invoices = Invoice::where(function ($query) use ($accountsId, $request) {
					$query->whereIn('account_id', $accountsId);
					if ($request->name) {
						$query->whereHas('opportunity', function($query) use($request) {
							$query->where('name', 'like', "%$request->name%");
						});
					}
					if ($request->user_id) {
						$query->where('user_id', '=', $request->user_id);
					}
					if ($request->contact_id) {
						$query->whereHas('opportunity', function($query) use($request) {
							$query->where('contact_id', $request->contact_id);
						})
						->get();
					}
					if ($request->status) {
						$query->where('status', '=', $request->status);
					}
				})
				->with([
					'opportunity',
					'invoiceLines',
					'account',
					'user',
					'contract',
				])
				->orderBy('pay_day', 'DESC')
				->paginate(20);
//dd($invoices);
		$invoices->appends([
			'status' => $request->status,
			'contact_id' => $request->contact_id,
			'user_id' => $request->user_id,
		]);

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('ID', 'ASC')
				->get();

		$users = myUsers();

		$totalInvoices = $invoices->total();

		return view('financial.invoices.indexInvoices', compact(
						'invoices',
						'contacts',
						'accounts',
						'users',
						'totalInvoices',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$accountsId = userAccounts();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();
		
		$companies = Company::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

//		$contracts = Contact::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();

		$opportunities = Opportunity::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$products = Product::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		return view('financial.invoices.createInvoice', compact(
						'accounts',
						'opportunities',
						'contacts',
//						'contracts',
						'companies',
						'products',
						'users',
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
					'pay_day' => 'required:invoices',
					'date_creation' => 'required:invoices',
					'opportunity_id' => 'required:invoices',
						],
						$messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
							->withErrors($validator)
							->withInput();
		} else {
			$invoice = new Invoice();

			$invoice->fill($request->all());
			$lastInvoice = Invoice::where('account_id', $request->account_id)
					->latest('id')
					->first();

			if ($request->status == 'rascunho' OR $request->status == 'orçamento') {
				$invoice->identifier = 0;
			} elseif ($lastInvoice != null) {
				$invoice->identifier = $lastInvoice->identifier + 1;
			} else {
				$invoice->identifier = 1;
			}
			$invoice->save();

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
						'subtotalPrice' => $request->product_amount [$key] * $request->product_price [$key],
					);
					$totalPrice = $totalPrice + $data['subtotalPrice'];
					$totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
					invoiceLine::insert($data);
				}
			}
			$invoice->totalPrice = $totalPrice - $request->discount;
			$invoice->number_installment = 1;
			$invoice->number_installment_total = $request->number_installment_total;
			$invoice->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
			$invoice->update();

			$invoices = Invoice::where('opportunity_id', $invoice->opportunity_id)
					->orderBy('PAY_DAY', 'ASC')
					->get();

			$totalInvoices = $invoices->count();

			$contracts = Contact::whereIn('account_id', userAccounts())
					->orderBy('NAME', 'ASC')
					->get();

			$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
					->with('product', 'opportunity')
					->get();

			$transactions = Transaction::whereHas('invoice', function($query) use($invoice) {
						$query->where('invoice_id', $invoice->id);
					})
					->get();

			$balance = $invoice->installment_value - $transactions->sum('value');

			return view('financial.invoices.showInvoice', compact(
							'invoice',
							'invoices',
							'totalInvoices',
							'contracts',
							'invoiceLines',
							'transactions',
							'balance',
			));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function show(Invoice $invoice) {
		$invoice = Invoice::where('id', $invoice->id)
				->with(['invoiceLines.product', 'contract', 'user.contact'])
				->first();
//		dd($invoice);

		$invoices = Invoice::where('opportunity_id', $invoice->opportunity_id)
				->orderBy('PAY_DAY', 'ASC')
				->get();

		$invoiceLines = InvoiceLine::whereHas('invoice', function ($query) use ($invoice) {
					$query->where('opportunity_id', $invoice->opportunity_id);
				})
				->get();
//		dd($invoice->opportunity_id);

		$totalInvoices = $invoices->count();

		$transactions = Transaction::whereHas('invoice', function($query) use($invoice) {
					$query->where('invoice_id', $invoice->id);
				})
				->get();

		$balance = $invoice->installment_value - $transactions->sum('value');

		return view('financial.invoices.showInvoice', compact(
						'invoice',
						'invoices',
						'invoiceLines',
						'totalInvoices',
						'transactions',
						'balance',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Invoice $invoice) {
		$accountsId = userAccounts();
		
		$accounts = Account::whereHas('users', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		$users = User::whereHas('accounts', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		$opportunities = Opportunity::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$companies = Company::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$products = Product::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$productsChecked = Invoice::find($invoice->id);

		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->get();

		$contracts = Contract::where('invoice_id', $invoice->id)
				->orderBy('ID', 'ASC')
				->get();

		return view('financial.invoices.editInvoice', compact(
						'invoice',
						'invoiceLines',
						'contracts',
						'accounts',
						'users',
						'opportunities',
						'companies',
						'products',
						'productsChecked',
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
			$lastInvoice = Invoice::where('account_id', $invoice->account_id)
					->latest('id')
					->first();

			$invoiceStatus = $invoice->status;

			$invoice->fill($request->all());

			if ($invoice->identifier == 0 AND $request->status == "aprovada" OR $request->status == "paga") {
				if ($lastInvoice->identifier > 0) {
					$invoice->identifier = $lastInvoice->identifier + 1;
				} else {
					$invoice->identifier = 1;
				}
			}
			$invoice->save();

			$totalPrice = 0;
			$totalTaxrate = 0;
			$products = $request['product_id'];
//	dd($request);
			if ($invoiceStatus == "rascunho" OR $invoice->status == "esboço") {
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
							'subtotalPrice' => $request->product_amount[$key] * $request->product_price[$key],
						);
						$totalPrice = $totalPrice + $data['subtotalPrice'];
						$totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
						if ($request->product_amount[$key] <= 0) {
							invoiceLine::where('id', $request->invoiceLine_id)->delete();
						} else {
							invoiceLine::where('id', $request->invoiceLine_id[$key])->update($data);
						}
					}
				}
				$totalPrice = 0;
				$totalTaxrate = 0;

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
							'subtotalPrice' => $request->new_product_amount [$key] * $request->new_product_price [$key],
						);
						$totalPrice = $totalPrice + $data['subtotalPrice'];
						$totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];
						invoiceLine::insert($data);
					}
				}
			}
			$invoices = Invoice::where('opportunity_id', $invoice->opportunity_id)
					->orderBy('PAY_DAY', 'ASC')
					->get();

			$totalInvoices = $invoices->count();

			$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
					->with('product', 'opportunity')
					->get();

//			$invoice->totalPrice = $invoiceLines->sum('subtotalPrice');
//			$invoice->installment_value = $invoice->totalPrice / $invoi;

			$invoice->save();

			$transactions = Transaction::whereHas('invoice', function($query) use($invoice) {
						$query->where('invoice_id', $invoice->id);
					})
					->get();

			$balance = $invoice->installment_value - $transactions->sum('value');

			$invoice->with('contract');

			return view('financial.invoices.showInvoice', compact(
							'invoice',
							'invoices',
							'totalInvoices',
							'invoiceLines',
							'transactions',
							'balance',
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

		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->with('product', 'opportunity')
				->get();

		$data = [
			'accountLogo' => $invoice->account->logo,
			'accountName' => $invoice->account->name,
			'accountEmail' => $invoice->account->email,
			'accountPhone' => $invoice->account->phone,
			'accountAddress' => $invoice->account->address,
			'accountAddressCity' => $invoice->account->address_city,
			'accountAddressState' => $invoice->account->address_state,
			'accountCnpj' => $invoice->account->cnpj,
			'invoiceIdentifier' => $invoice->identifier,
			'invoiceDescription' => $invoice->description,
			'opportunityDescription' => $invoice->opportunity->description,
			'invoiceDiscount' => $invoice->discount,
			'invoicePayday' => $invoice->pay_day,
			'invoiceTotalPrice' => $invoice->totalPrice,
			'customerName' => $invoice->opportunity->contact->name,
			'companyName' => $invoice->opportunity->company->name,
			'companyCnpj' => $invoice->opportunity->company->cnpj,
			'companyEmail' => $invoice->opportunity->company->email,
			'companyPhone' => $invoice->opportunity->company->phone,
			'companyAddress' => $invoice->opportunity->company->address,
			'companyCity' => $invoice->opportunity->company->city,
			'companyState' => $invoice->opportunity->company->state,
			'companyCountry' => $invoice->opportunity->company->country,
			'invoiceLines' => $invoiceLines,
//			'deadline' => $deadline,
		];

		$pdf = PDF::loadView('financial.invoices.pdfInvoice', compact('data'));

// download PDF file with download method
		return $pdf->stream('fatura.pdf');
	}

// Generate parcelamento a partir de uma fatura já criada
	public function generateInstallment(Invoice $invoice) {
		$lastInvoice = Invoice::where('account_id', $invoice->account_id)
				->latest('id')
				->first();

		$invoice->identifier = $lastInvoice->identifier;
		$invoice->save();

		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->with('product')
				->get();

		$counter = 1;
		while ($counter <= $invoice->number_installment_total - 1) {
			$invoiceNew = new Invoice();
			if ($lastInvoice != null) {
				$invoiceNew->identifier = $lastInvoice->identifier + $counter;
			} else {
				$invoiceNew->identifier = $counter;
			}
			$invoiceNew->opportunity_id = $invoice->opportunity_id;
			$invoiceNew->user_id = $invoice->user_id;
			$invoiceNew->account_id = $invoice->account_id;
			$invoiceNew->contract_id = $invoice->contract_id;
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
			$invoiceNew->payment_method = $invoice->payment_method;
			$invoiceNew->number_installment = $counter + 1;
			$invoiceNew->number_installment_total = $invoice->number_installment_total;
			$invoiceNew->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
			$invoiceNew->status = $invoice->status;
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
		return redirect()->action('Financial\\InvoiceController@index');
	}

}

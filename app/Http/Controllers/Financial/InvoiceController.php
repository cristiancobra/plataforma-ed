<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\Product;
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
				])
				->orderBy('pay_day', 'DESC')
				->paginate(20);
		
		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('ID', 'ASC')
				->get();

		$users = myUsers();

		$totalInvoices = $invoices->count();

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
		$invoice = new Invoice();

		$accountsId = userAccounts();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

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
						'invoice',
						'accounts',
						'opportunities',
						'contacts',
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
			$lastInvoice = Invoice::where('account_id', $request->account_id)
					->latest('id')
					->first();

			$counter = 1;
			while ($counter <= $request->number_installment_total) {
				$invoice = new Invoice();
				if ($lastInvoice != null) {
					$invoice->identifier = $lastInvoice->identifier + $counter;
				} else {
					$invoice->identifier = $counter;
				}
				$invoice->opportunity_id = $request->opportunity_id;
				$invoice->user_id = $request->user_id;
				$invoice->account_id = $request->account_id;
				$invoice->date_creation = $request->date_creation;
				$invoice->pay_day = date("Y-m-d", strtotime("+" . ($counter - 1) . " month", strtotime($request->pay_day)));
				$invoice->description = $request->description;
				$invoice->discount = $request->discount;
				$invoice->status = $request->status;
				$invoice->save();

				$totalPrice = 0;
				$totalTaxrate = 0;

				foreach ($request->product_id as $key => $product_id) {
					if ($request->product_amount [$key] != null) {
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
				$invoice->number_installment = $counter;
				$invoice->number_installment_total = $request->number_installment_total;
				$invoice->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
				$invoice->update();
				$counter++;
			}
		}

		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->with('product', 'opportunity')
				->get();

		return view('financial.invoices.showInvoice', compact(
						'invoice',
						'invoiceLines',
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function show(Invoice $invoice) {
		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->with('product', 'opportunity')
				->get();

		return view('financial.invoices.showInvoice', compact(
						'invoice',
						'invoiceLines',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Invoice $invoice) {

		if (Auth::check()) {
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

			$products = Product::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$productsChecked = Invoice::find($invoice->id);

			$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
					->get();

//			$productExisting = InvoiceLine::whereHas('invoice', function($query) use($user) {
//					$query->where('invoices.id', $invoice->id);
//				})
//				->pluck('product_id')
//				->toArray();

			$id = 'id001';
			$productId = 'productId001';
			$name = 'name001';
			$amount = 'amount001';
			$hours = 'hours001';
			$dueDate = 'dueDate001';
			$cost = 'cost001';
			$taxRate = 'taxRate001';
			$margin = 'margin001';
			$price = 'price001';

			return view('financial.invoices.editInvoice', compact(
							'invoice',
							'invoiceLines',
//							'productExisting',
							'accounts',
							'users',
							'opportunities',
							'products',
							'productsChecked',
							'id',
							'productId',
							'name',
							'amount',
							'hours',
							'dueDate',
							'cost',
							'taxRate',
							'margin',
							'price',
			));
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Invoice $invoice) {
		$invoice->opportunity_id = $request->opportunity_id;
		$invoice->user_id = $request->user_id;
		$invoice->account_id = $request->account_id;
		$invoice->date_creation = $request->date_creation;
		$invoice->pay_day = $request->pay_day;
		$invoice->description = $request->description;
		$invoice->discount = $request->discount;
		$invoice->payment_method = $request->payment_method;
		$invoice->number_installment = $invoice->number_installment;
		$invoice->status = $request->status;

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
			$invoice->save();
		}

		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->with('product', 'opportunity')
				->get();

		$totalPrice = 0;
		$totalTaxrate = 0;

		$id = 'id001';
		$productId = 'productId001';
		$name = 'name001';
		$amount = 'amount001';
		$hours = 'hours001';
		$dueDate = 'dueDate001';
		$cost = 'cost001';
		$taxRate = 'taxRate001';
		$margin = 'margin001';
		$price = 'price001';

		while ($request->$name != null) {
//			foreach ($request->product_id as $key => $product_id) {
			$data = array(
				'id' => $request->$id,
				'invoice_id' => $invoice->id,
				'product_id' => $request->$productId,
				'amount' => $request->$amount,
				'subtotalHours' => $request->$amount * $request->$hours,
				'subtotalDeadline' => $request->$amount * $request->$dueDate,
				'subtotalCost' => $request->$amount * $request->$cost,
				'subtotalTax_rate' => $request->$amount * $request->$taxRate,
				'subtotalMargin' => $request->$amount * $request->$margin,
				'subtotalPrice' => $request->$amount * $request->$price,
			);
			$totalPrice = $totalPrice + $data['subtotalPrice'];
			$totalTaxrate = $totalTaxrate + $data['subtotalTax_rate'];

			if ($request->$amount <= 0) {
				invoiceLine::where('id', $request->$id)->delete();
			} else {
				invoiceLine::where('id', $request->$id)->update($data);
			}

			$id++;
			$productId++;
			$name++;
			$amount++;
			$hours++;
			$dueDate++;
			$cost++;
			$taxRate++;
			$margin++;
			$price++;
		}

		foreach ($request->new_product_id as $key => $product_id) {
			if ($request->product_amount [$key] != null) {
				$data = array(
					'invoice_id' => $invoice->id,
					'product_id' => $request->new_product_id [$key],
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
//		$invoice->number_installment = $request->number_installment;
//		$invoice->number_installment_total = $request->number_installment_total;
		$invoice->installment_value = $invoice->totalPrice / $invoice->number_installment_total;
		$invoice->update();

		return view('financial.invoices.showInvoice', [
			'invoice' => $invoice,
			'invoiceLines' => $invoiceLines,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Invoice $invoice) {
		$invoice->delete();
		return redirect()->action('Financial\\InvoiceController@index');
	}

// Generate PDF
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
			'invoiceId' => $invoice->id,
			'invoiceDescription' => $invoice->description,
			'opportunityDescription' => $invoice->opportunity->description,
			'invoiceDiscount' => $invoice->discount,
			'invoicePayday' => $invoice->pay_day,
			'invoiceTotalPrice' => $invoice->totalPrice,
			'customerName' => $invoice->opportunity->contact->name,
			'customerEmail' => $invoice->opportunity->contact->email,
			'customerPhone' => $invoice->opportunity->contact->phone,
			'customerAddress' => $invoice->opportunity->contact->address,
			'customerCity' => $invoice->opportunity->contact->city,
			'customerState' => $invoice->opportunity->contact->state,
			'customerCountry' => $invoice->opportunity->contact->country,
			'invoiceLines' => $invoiceLines,
//			'deadline' => $deadline,
		];

		$pdf = PDF::loadView('financial.invoices.pdfInvoice', compact('data'));

// download PDF file with download method
		return $pdf->stream('fatura.pdf');
	}

}

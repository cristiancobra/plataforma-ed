<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunitie;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');

			$invoices = Invoice::whereIn('account_id', $accountsID)
					->with([
						'opportunitie',
						'invoiceLines',
						'account',
					])
					->orderBy('pay_day', 'DESC')
					->paginate(20);
//dd($invoices);
			$totalInvoices = $invoices->count();

			return view('financial.invoices.indexInvoices', [
				'invoices' => $invoices,
				'totalInvoices' => $totalInvoices,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$invoice = new Invoice();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$opportunities = Opportunitie::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$products = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			return view('financial.invoices.createInvoice', [
				'userAuth' => $userAuth,
				'invoice' => $invoice,
				'accounts' => $accounts,
				'opportunities' => $opportunities,
				'contacts' => $contacts,
				'products' => $products,
				'users' => $users,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$invoice = new Invoice();

		$invoice->opportunitie_id = $request->opportunitie_id;
		$invoice->user_id = $request->user_id;
		$opportunitie = Opportunitie::find($invoice->opportunitie_id)->with('account')->first();
		$invoice->account_id = $opportunitie->account->id;
		$invoice->date_creation = $request->date_creation;
		$invoice->pay_day = $request->pay_day;
		$invoice->description = $request->description;
		$invoice->status = $request->status;
		$invoice->save();

//		foreach($request->product_id as $invoiceLine) {
//				$invoiceLine = new InvoiceLine;
//				$invoiceLine->invoice_id = $request->opportunitie_id;
//				$invoiceLine->amount = $request->amount;
//				$invoiceLine->save();
//			}

		if ($invoice->save()) {
			foreach ($request->product_id as $key => $product_id) {
				if ($request->product_amount [$key] != null) {
				$data = array(
					'invoice_id' => $invoice->id,
					'product_id' => $request->product_id [$key],
					'amount' => $request->product_amount [$key],
					'subtotalHours' => $request->product_amount [$key] * $request->product_work_hours [$key],
					'subtotalCost' => $request->product_amount [$key] * $request->product_cost [$key],
					'subtotalMargin' => $request->product_amount [$key] * $request->product_margin [$key],
					'subtotalPrice' => $request->product_amount [$key] * $request->product_price [$key],
				);
				invoiceLine::insert($data);
				}
			}
		}

		return redirect()->action('Financial\\InvoiceController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function show(Invoice $invoice) {
		$userAuth = Auth::user();
		
		$invoiceLines = InvoiceLine::where('invoice_id', $invoice->id)
				->with('product','opportunitie')
				->get();
//		$invoiceLines = $invoice->invoiceLines();
//dd($invoiceLines);
		return view('financial.invoices.showInvoice', [
			'userAuth' => $userAuth,
			'invoice' => $invoice,
			'invoiceLines' => $invoiceLines,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Invoice $invoice) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			$opportunities = Opportunitie::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$products = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$productsChecked = Invoice::find($invoice->id);

//			$productsChecked = Opportunitie::whereHas('accounts', function($query) use($account) {
//						$query->where('account_id', $account->id);
//					})
//					->pluck('id')
//					->toArray();

			$name = "name0001";
			$amount = "amount0001";
			$hours = "hours0001";
			$cost = "cost0001";
			$tax_rate = "tax_rate0001";
			$price = "price0001";
			$margin = "margin0001";

			return view('financial.invoices.editInvoice', [
				'userAuth' => $userAuth,
				'invoice' => $invoice,
				'accounts' => $accounts,
				'opportunities' => $opportunities,
				'products' => $products,
				'productsChecked' => $productsChecked,
				'name' => $name,
				'amount' => $amount,
				'hours' => $hours,
				'cost' => $cost,
				'tax_rate' => $tax_rate,
				'price' => $price,
				'margin' => $margin,
			]);
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
		$userAuth = Auth::user();

		$name = "name0001";
		$amount = "amount0001";
		$hours = "hours0001";
		$cost = "cost0001";
		$tax_rate = "tax_rate0001";
		$price = "price0001";
		$margin = "margin0001";

		$totalAmount = 0;
		$totalHours = 0;
		$totalCost = 0;
		$totalTax_rate = 0;
		$totalPrice = 0;
		$totalMargin = 0;

		$invoice->fill($request->all());

		while ($request->$name != null) {
			$invoice->$name = $request->$name;

			$invoice->$amount = $request->$amount;
			$totalAmount = $totalAmount + $request->$amount;

			$invoice->$hours = $request->$hours * $request->$amount;
			$totalHours = $totalHours + $invoice->$hours;

			$invoice->$cost = $request->$cost * $request->$amount;
			$totalCost = $totalCost + $invoice->$cost;

			$invoice->$tax_rate = $request->$tax_rate * $request->$amount;
			$totalTax_rate = $totalTax_rate + $invoice->$tax_rate;

			$invoice->$price = $request->$price * $request->$amount;
			$totalPrice = $totalPrice + $invoice->$price;

			$invoice->$margin = $request->$margin * $request->$amount;
			$totalMargin = $totalMargin + $invoice->$margin;

			$name++;
			$amount++;
			$hours++;
			$cost++;
			$tax_rate++;
			$price++;
			$margin++;
		}

		$invoice->save();

		return view('financial.invoices.showInvoice', [
			'invoice' => $invoice,
			'userAuth' => $userAuth,
			'name' => $name,
			'amount' => $amount,
			'hours' => $hours,
			'cost' => $cost,
			'tax_rate' => $tax_rate,
			'price' => $price,
			'margin' => $margin,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Invoice $invoice) { {
			$invoice->delete();
			return redirect()->action('Financial\\InvoiceController@index');
		}
	}

}

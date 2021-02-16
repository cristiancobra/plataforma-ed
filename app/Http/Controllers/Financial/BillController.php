<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;


class BillController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$bills = Bill::where(function ($query) use ($request) {
					$query->whereIn('account_id', userAccounts());
					if ($request->name) {
						$query->whereHas('opportunity', function($query) use($request) {
							$query->where('name', 'like', "%$request->name%");
						});
					}
					if ($request->user_id) {
						$query->where('user_id', '=', $request->user_id);
					}
//					if ($request->contact_id) {
//						$query->whereHas('opportunity', function($query) use($request) {
//							$query->where('contact_id', $request->contact_id);
//						})
//						->get();
//					}
					if ($request->status) {
						$query->where('status', '=', $request->status);
					}
				})
				->with([
//					'opportunity',
//					'invoiceLines.product',
//					'account.bankAccounts',
					'user.contact',
//					'contract',
				])
				->orderBy('pay_day', 'DESC')
				->paginate(20);
//dd($invoices);
		$bills->appends([
			'status' => $request->status,
			'contact_id' => $request->contact_id,
			'user_id' => $request->user_id,
		]);

		$contacts = Contact::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereIn('id', userAccounts())
				->orderBy('ID', 'ASC')
				->get();

		$users = myUsers();

		$totalBills = $bills->total();

		return view('financial.bills.indexBills', compact(
						'bills',
						'contacts',
						'accounts',
						'users',
						'totalBills',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$accounts = Account::whereIn('id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

		$companies = Company::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

		$contacts = Contact::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->get();

//		$contracts = Contact::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();

//		$opportunities = Opportunity::whereIn('account_id', userAccounts())
//				->orderBy('NAME', 'ASC')
//				->get();

		$products = Product::whereIn('account_id', userAccounts())
				->where('type', 'expense')
				->orderBy('NAME', 'ASC')
				->get();

		$users = User::whereHas('accounts', function($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->get();

		return view('financial.bills.createBill', compact(
						'accounts',
//						'opportunities',
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
						],
						$messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
							->withErrors($validator)
							->withInput();
		} else {
			$bill = new Bill();

			$bill->fill($request->all());
			$lastBill = Bill::where('account_id', $request->account_id)
					->latest('id')
					->first();

			if ($request->status == 'rascunho' OR $request->status == 'orçamento') {
				$bill->identifier = 0;
			} elseif ($lastInvoice != null) {
				$bill->identifier = $lastInvoice->identifier + 1;
			} else {
				$bill->identifier = 1;
			}
			$bill->save();

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
			$bill->total_price = $totalPrice - $request->discount;
			$bill->number_installment = 1;
			$bill->number_installment_total = $request->number_installment_total;
			$bill->installment_value = $bill->totalPrice / $bill->number_installment_total;
			$bill->update();

//			$bills = Bill::where('opportunity_id', $bill->opportunity_id)
//					->orderBy('PAY_DAY', 'ASC')
//					->get();

//			$totalBills = $bills->count();

			$contracts = Contact::whereIn('account_id', userAccounts())
					->orderBy('NAME', 'ASC')
					->get();

//			$billLines = InvoiceLine::where('invoice_id', $bill->id)
//					->with('product', 'opportunity')
//					->get();

			$transactions = Transaction::whereHas('invoice', function($query) use($bill) {
						$query->where('invoice_id', $bill->id);
					})
					->get();

			$balance = $bill->installment_value - $transactions->sum('value');

			return view('financial.bills.showBill', compact(
							'bill',
//							'bills',
//							'totalBills',
							'contracts',
//							'billLines',
							'transactions',
							'balance',
			));
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function show(Bill $bill) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Bill $bill) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Bill $bill) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Bill  $bill
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Bill $bill) {
		//
	}

}

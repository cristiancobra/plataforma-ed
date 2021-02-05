<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\Invoice;
use App\Models\Transaction;

class TransactionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$transactions = Transaction::whereIn('account_id', userAccounts())
				->with(['user', 'bankAccount', 'invoice'])
				->orderBy('PAY_DAY', 'ASC')
				->paginate(20);

		return view('financial.transactions.indexTransactions', compact(
						'transactions',
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
				->paginate(20);

		$bankAccounts = BankAccount::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$users = myUsers();

		return view('financial.transactions.createTransaction', compact(
						'accounts',
						'bankAccounts',
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
//					'value' => 'required:transactions',
					'pay_day' => 'required:transactions',
						],
						$messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {
			$transaction = new Transaction();
			$transaction->fill($request->all());
//			dd($transaction);
			$transaction->save();

			return view('financial.transactions.showTransaction', compact(
							'transaction',
			));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function show(Transaction $transaction) {
		return view('financial.transactions.showTransaction', compact(
						'transaction',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Transaction $transaction) {
		$accounts = Account::whereIn('id', userAccounts())
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$bankAccounts = BankAccount::whereIn('account_id', userAccounts())
				->orderBy('NAME', 'ASC')
				->paginate(20);
		
		$invoices = Invoice::whereIn('account_id', userAccounts())
				->orderBy('ID', 'DESC')
				->get();

		$users = myUsers();

		return view('financial.transactions.editTransaction', compact(
						'transaction',
						'accounts',
						'bankAccounts',
						'invoices',
						'users',
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Transaction $transaction) {
		$transaction->fill($request->all());
		$transaction->save();

		return view('financial.transactions.showTransaction', compact(
						'transaction',
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Transaction $transaction) {
		$transaction->delete();
		return redirect()->action('Financial\\InvoiceController@index');
	}

}

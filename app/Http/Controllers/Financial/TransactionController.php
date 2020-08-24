<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller {

	public function dashboard() {
		$transactions = Transaction::where('deleted_at', '!=', 'null')
				->limit(8)
				->orderByDesc('id')
				->get();
		
		$userAuth = Auth::user();

		$expenses = Transaction::where([
					['deleted_at', '!=', 'null'],
					['type', '=', 'expense']
				])
				->get();

		$incomes = Transaction::where([
					['deleted_at', '!=', 'null'],
					['type', '=', 'income']
				])
				->get();

		$totalExpenses = $expenses->sum('amount');
		$totalIncomes = $incomes->sum('amount');
		$saldoInicial = 0;
		$total = $saldoInicial + $totalIncomes - $totalExpenses;

		return view('financial.dashboardFinancial', [
			'transactions' => $transactions,
			'totalExpenses' => $totalExpenses,
			'totalIncomes' => $totalIncomes,
			'expenses' => $expenses,
			'incomes' => $incomes,
			'userAuth' => $userAuth,
			'total' => $total,
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$transactions = Transaction::where('deleted_at', '!=', 'null')
				->orderByDesc('id')
				->get();

		$user = Auth::user();

		return view('financial.transactions.indexTransactions', [
			'transactions' => $transactions,
			'user' => $user,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function show(Transaction $transaction) {
		$user = Auth::user();
		$transactions = Email::where('id', '=', $user->id)->with('users')->get();
		//	$accounts = User::where('id', '=', $user->id)->with('accounts')->get();
		return view('emails.detailsEmail', [
			'email' => $transaction,
			'emails' => $transactions,
			'user' => $user,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Transaction  $transactionModel
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Transaction $transaction) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Transaction  $transactionModel
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Transaction $transaction) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Transaction  $transactionModel
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Transaction $transaction) {
		//
	}

}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunitie;
use App\Models\Product;
use Illuminate\Http\Request;

class ContractController extends Controller {

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

			$contracts = Contract::whereIn('account_id', $accountsID)
					->with([
						'contact',
						'account',
//						'products'
					])
					->orderBy('NAME', 'ASC')
					->paginate(20);

			$totalContracts = $contracts->count();

			return view('sales.contracts.indexContracts', [
				'contracts' => $contracts,
				'totalContracts' => $totalContracts,
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
			$contract = new Contract();

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

			return view('sales.contracts.createContract', [
				'userAuth' => $userAuth,
				'contract' => $contract,
				'accounts' => $accounts,
				'opportunities' => $opportunities,
				'contacts' => $contacts,
				'products' => $products,
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
		$contract = new Contract;
		$contract->name = $request->name;
		$contract->account_id = $request->account_id;
		$contract->contact_id = $request->contact_id;
		$contract->witness1 = $request->witness1;
		$contract->witness2 = $request->witness2;
		$contract->save();

		return redirect()->action('Sales\\ContractController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function show(Contract $contract) {
		$userAuth = Auth::user();

		return view('sales.contracts.showContract', [
			'contract' => $contract,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contract $contract) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Contract $contract) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Contract $contract) { {
			$contract->delete();
			return redirect()->action('Sales\\ContractController@index');
		}
	}

}

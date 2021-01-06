<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\ContractTemplate;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\User;

class ContractController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) {
						$query->where('users.id', Auth::user()->id);
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
		if (Auth::check()) {
			$contract = new Contract();

			$accountsId = Account::whereHas('users', function($query) {
						$query->where('users.id', Auth::user()->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$contacts = Contact::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$opportunities = Opportunity::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$contractsTemplates = ContractTemplate::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			return view('sales.contracts.createContract', compact(
							'contract',
							'accounts',
							'opportunities',
							'contacts',
							'contractsTemplates',
			));
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
		$contract->fill($request->all());
		$contract->text = ContractTemplate::find($request->contractTemplate_id)->pluck('text');
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

		$account = Account::find($contract->account_id);
		$contact = Contact::find($contract->contact_id);
		$user = User::find($contract->user_id)
				->with('contact')
				->get();
		
//		$user = $contract->userContact();
		dd($user);
		
		return view('sales.contracts.showContract', compact(
			'contract',
			'contact',
			'account',
			'user',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contract $contract) {
		if (Auth::check()) {

			$accountsId = Account::whereHas('users', function($query) {
						$query->where('users.id', Auth::user()->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$contacts = Contact::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$witness1 = Contact::find($contract->witness1);
			$witnessName1 = $witness1->name;

			$witness2 = Contact::find($contract->witness2);
			$witnessName2 = $witness2->name;

			$opportunities = Opportunity::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$contractsTemplates = ContractTemplate::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			return view('sales.contracts.editContract', compact(
							'contract',
							'accounts',
							'opportunities',
							'contacts',
							'witnessName1',
							'witnessName2',
							'contractsTemplates',
			));
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Contract  $contract
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Contract $contract) {
		$contract->fill($request->all());
		$contract->save();

		return view('sales.contracts.showContract', compact('contract'));
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

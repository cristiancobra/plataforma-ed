<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Company;

class CompanyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$accountsId = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
				})
				->get('id');

		$companies = Company::whereIn('account_id', $accountsId)
				->with([
					'company',
					'account',
				])
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$totalCompanies = $companies->count();

		return view('sales.companies.indexCompanies', compact(
						'companies',
						'totalCompanies',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		$accountsId = Account::whereHas('users', function($query) {
					$query->where('users.id', Auth::user()->id);
				})
				->pluck('id');

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$states = returnStates();

		return view('sales.companies.createCompany', compact(
						'accounts',
						'states',
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$company = new Company();
		$company->fill($request->all());
		$company->save();

//		$account = Account::find($company->account_id);
//		$contact = Contact::find($contract->contact_id);
//		$user = User::where('id', $contract->user_id)
//				->with('contact')
//				->first();

		return view('sales.companies.showCompany', compact(
						'company',
//						'account',
//						'contact',
//						'user',
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function show(Company $company) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Company $company) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Company $company) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Company $company) {
		//
	}

}

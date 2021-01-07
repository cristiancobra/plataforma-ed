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
		$accountsId = userAccounts();

		$companies = Company::whereIn('account_id', $accountsId)
				->with([
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


		return view('sales.companies.showCompany', compact(
						'company',
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function show(Company $company) {
		return view('sales.companies.showCompany', compact(
						'company',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Company $company) {
		$accountsId = userAccounts();
		$states = returnStates();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		return view('sales.companies.editCompany', compact(
						'company',
						'accounts',
						'states',
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Company $company) {
		$company->fill($request->all());
		$company->save();


		return view('sales.companies.showCompany', compact(
						'company',
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Company  $company
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Company $company) {
			$company->delete();
			return redirect()->action('Sales\\CompanyController@index');
		}
	}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Opportunity;
use App\Models\Product;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class OpportunityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->get('id');

			$opportunities = Opportunity::whereIn('account_id', $accountsID)
					->with('user')
					->orderBy('DATE_CONCLUSION', 'ASC')
					->paginate(20);

			$totalOpportunities = $opportunities->count();

			return view('sales.opportunities.indexOpportunities', [
				'opportunities' => $opportunities,
				'totalOpportunities' => $totalOpportunities,
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
			$opportunity = new Opportunity();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->with('contact')
					->orderBy('NAME', 'ASC')
					->get();

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$products = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$status = returnStatus();
			$stages = returnOpportunitieStage();

			return view('sales.opportunities.createOpportunity', [
				'userAuth' => $userAuth,
				'opportunity' => $opportunity,
				'accounts' => $accounts,
				'users' => $users,
				'contacts' => $contacts,
				'products' => $products,
				'status' => $status,
				'stages' => $stages,
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
		$userAuth = Auth::user();

		$opportunity = new Opportunity();
		$opportunity->fill($request->all());

		$messages = [
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'name' => 'required:opportunities',
					'date_start' => 'required:opportunities',
					'description' => 'required:opportunities',
						],
						$messages);

		if ($validator->fails()) {
			return back()
							->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
							->withErrors($validator)
							->withInput();
		} else {
			$opportunity->user()->associate($request->user_id);
			$opportunity->save();

			$invoices = Invoice::where('opportunity_id', $opportunity->id)
					->orderBy('PAY_DAY', 'ASC')
					->get();

			$tasks = Task::where('opportunity_id', $opportunity->id)
					->get();

			return view('sales.opportunities.showOpportunity', [
				'opportunity' => $opportunity,
				'invoices' => $invoices,
				'tasks' => $tasks,
				'userAuth' => $userAuth,
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Opportunity  $opportunity
	 * @return \Illuminate\Http\Response
	 */
	public function show(Opportunity $opportunity) {
		$userAuth = Auth::user();

		$invoices = Invoice::where('opportunity_id', $opportunity->id)
				->orderBy('PAY_DAY', 'ASC')
				->get();

		$tasks = Task::where('opportunity_id', $opportunity->id)
				->get();

		return view('sales.opportunities.showOpportunity', [
			'opportunity' => $opportunity,
			'invoices' => $invoices,
			'tasks' => $tasks,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Opportunity  $opportunity
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Opportunity $opportunity) {
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

			$opportunities = Opportunity::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$users = User::whereHas('accounts', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->with('contact')
					->orderBy('NAME', 'ASC')
					->get();

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$invoices = Invoice::where('opportunity_id', $opportunity->id)
					->orderBy('PAY_DAY', 'ASC')
					->get();


			$status = returnStatus();

			return view('sales.opportunities.editOpportunity', [
				'userAuth' => $userAuth,
				'opportunity' => $opportunity,
				'accounts' => $accounts,
				'users' => $users,
				'contacts' => $contacts,
				'opportunities' => $opportunities,
				'invoices' => $invoices,
				'status' => $status,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Opportunity  $opportunity
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Opportunity $opportunity) {
		$userAuth = Auth::user();

		$opportunity->fill($request->all());
		$opportunity->user()->associate($request->user_id);
		$opportunity->save();

		$invoices = Invoice::where('opportunity_id', $opportunity->id)
				->orderBy('PAY_DAY', 'ASC')
				->get();

		$tasks = Task::where('opportunity_id', $opportunity->id)
				->get();

		return view('sales.opportunities.showOpportunity', [
			'opportunity' => $opportunity,
			'invoices' => $invoices,
			'userAuth' => $userAuth,
			'tasks' => $tasks,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Opportunity  $opportunity
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Opportunity $opportunity) {
		$opportunity->delete();
		return redirect()->action('Sales\\OpportunityController@index');
	}

}

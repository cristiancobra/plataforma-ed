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
		$accountsId = userAccounts();

		$opportunities = Opportunity::where(function ($query) use ($accountsId, $request) {
					$query->whereIn('account_id', $accountsId);
					if ($request->name) {
						$query->where('name', 'like', "%$request->name%");
					}
					if ($request->user_id) {
						$query->where('user_id', '=', $request->user_id);
					}
					if ($request->contact_id) {
						$query->where('contact_id', '=', $request->contact_id);
					}
					if ($request->stage) {
						$query->where('stage', '=', $request->stage);
					}else{
						$query->where('stage', '!=', 'ganhamos');
					}
				})
				->with('user')
				->orderBy('DATE_CONCLUSION', 'ASC')
				->paginate(20);

		$totalOpportunities = $opportunities->total();

		$contacts = Contact::whereIn('account_id', $accountsId)
				->orderBy('NAME', 'ASC')
				->get();

		$accounts = Account::whereIn('id', $accountsId)
				->orderBy('ID', 'ASC')
				->get();

		$users = myUsers();

		return view('sales.opportunities.indexOpportunities', compact(
						'opportunities',
						'totalOpportunities',
						'contacts',
						'accounts',
						'users',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

			$opportunity = new Opportunity();

			$accountsId = userAccounts();

			$accounts = Account::whereIn('id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$users = myUsers();

			$contacts = Contact::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$products = Product::whereIn('account_id', $accountsId)
					->orderBy('NAME', 'ASC')
					->get();

			$stages = returnOpportunitiesStage();

			return view('sales.opportunities.createOpportunity', compact(
				'opportunity',
				'accounts',
				'users',
				'contacts',
				'products',
				'stages',
			));
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
		$invoices = Invoice::where('opportunity_id', $opportunity->id)
				->orderBy('PAY_DAY', 'ASC')
				->get();

		$tasks = Task::where('opportunity_id', $opportunity->id)
				->get();

		return view('sales.opportunities.showOpportunity', [
			'opportunity' => $opportunity,
			'invoices' => $invoices,
			'tasks' => $tasks,
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

			$users = myUsers();

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$invoices = Invoice::where('opportunity_id', $opportunity->id)
					->orderBy('PAY_DAY', 'ASC')
					->get();

			$stages = returnOpportunitiesStage();

			return view('sales.opportunities.editOpportunity', [
				'userAuth' => $userAuth,
				'opportunity' => $opportunity,
				'accounts' => $accounts,
				'users' => $users,
				'contacts' => $contacts,
				'opportunities' => $opportunities,
				'invoices' => $invoices,
				'stages' => $stages,
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

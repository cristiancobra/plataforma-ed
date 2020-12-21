<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Opportunitie;
use App\Models\Product;
use App\Models\Task;
use Illuminate\Http\Request;

class OpportunitieController extends Controller {

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

			$opportunities = Opportunitie::whereIn('account_id', $accountsID)
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
			$opportunitie = new Opportunitie();

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

			$products = Product::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			return view('sales.opportunities.createOpportunitie', [
				'userAuth' => $userAuth,
				'opportunitie' => $opportunitie,
				'accounts' => $accounts,
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
		$userAuth = Auth::user();

		$opportunitie = new Opportunitie();
		$opportunitie->fill($request->all());

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
			$opportunitie->save();

			$invoices = Invoice::where('opportunitie_id', $opportunitie->id)
					->orderBy('PAY_DAY', 'ASC')
					->get();

			return view('sales.opportunities.showOpportunitie', [
				'opportunitie' => $opportunitie,
				'invoices' => $invoices,
				'userAuth' => $userAuth,
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function show(Opportunitie $opportunitie) {
		$userAuth = Auth::user();

		$invoices = Invoice::where('opportunitie_id', $opportunitie->id)
				->orderBy('PAY_DAY', 'ASC')
				->get();

		$tasks = Task::where('opportunitie_id', $opportunitie->id)
//				->orderBy('PAY_DAY', 'ASC')
				->get();

		return view('sales.opportunities.showOpportunitie', [
			'opportunitie' => $opportunitie,
			'invoices' => $invoices,
			'tasks' => $tasks,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Opportunitie $opportunitie) {
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

			$contacts = Contact::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$invoices = Invoice::where('opportunitie_id', $opportunitie->id)
					->orderBy('PAY_DAY', 'ASC')
					->get();

			return view('sales.opportunities.editOpportunitie', [
				'userAuth' => $userAuth,
				'opportunitie' => $opportunitie,
				'accounts' => $accounts,
				'contacts' => $contacts,
				'opportunities' => $opportunities,
				'invoices' => $invoices,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Opportunitie $opportunitie) {
		$userAuth = Auth::user();

		$opportunitie->fill($request->all());
		$opportunitie->save();

		$invoices = Invoice::where('opportunitie_id', $opportunitie->id)
				->orderBy('PAY_DAY', 'ASC')
				->get();

		return view('sales.opportunities.showOpportunitie', [
			'opportunitie' => $opportunitie,
			'invoices' => $invoices,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Opportunitie $opportunitie) {
		$opportunitie->delete();
		return redirect()->action('Sales\\OpportunitieController@index');
	}

}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Opportunitie;
use App\Models\Product;
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
					->orderBy('NAME', 'ASC')
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
		Opportunitie::create($request->all());

		return redirect()->action('Sales\\OpportunitieController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function show(Opportunitie $opportunitie) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Opportunitie $opportunitie) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Opportunitie $opportunitie) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Opportunitie  $opportunitie
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Opportunitie $opportunitie) {
		//
	}

}

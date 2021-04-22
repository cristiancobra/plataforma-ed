<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Models\Competitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class CompetitorController extends Controller {

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
					->pluck('id');

			$competitors = Competitor::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->paginate(20);

			$total = $competitors->count();

			return view('market.competitors.indexCompetitors', compact(
				'competitors',
				'total',
			));
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
		$competitor = new Competitor();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

			$competitors = Competitor::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->paginate(20);

			return view('market.competitors.createCompetitor', [
				'userAuth' => $userAuth,
				'competitor' => $competitor,
				'competitors' => $competitors,
				'accounts' => $accounts,
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
		$competitor = new Competitor();
		$competitor->fill($request->all());
		$competitor->save();

		return redirect()->action('Market\\CompetitorController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Competitor  $competitors
	 * @return \Illuminate\Http\Response
	 */
	public function show(Competitor $competitor) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			return view('market.competitors.showCompetitor', [
				'competitor' => $competitor,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Competitor  $competitors
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Competitor $competitor) {
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

			return view('market.competitors.editCompetitor', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'competitor' => $competitor,
				'accounts' => $accounts,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Competitor  $competitors
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Competitor $competitor) {
		$userAuth = Auth::user();

		$competitor->fill($request->all());
		$competitor->save();

		return view('market.competitors.showCompetitor', [
			'userAuth' => $userAuth,
			'competitor' => $competitor,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Competitor  $competitors
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Competitor $competitor) {
		$competitor->delete();
		return redirect()->route('competitor.index');
	}

}

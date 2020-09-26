<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Pinterest;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinterestController extends Controller {

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

			$pinterests = Pinterest::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('account');
					})
					->paginate(20);

			$totalPinterests = $pinterests->count();

			$score = $pinterests->count();

			return view('socialmedia.pinterests.indexPinterests', [
				'pinterests' => $pinterests,
				'userAuth' => $userAuth,
				'score' => $score,
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
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();
			return view('socialmedia.pinterests.createPinterest', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
			]);
		} else {
			return redirect('/');
		}
	}

	//

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		Pinterest::create($request->all());

		return redirect()->action('Socialmedia\\PinterestController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Pinterest  $pinterest
	 * @return \Illuminate\Http\Response
	 */
	public function show(Pinterest $pinterest) {
		$userAuth = Auth::user();

		return view('socialmedia.pinterests.showPinterest', [
			'pinterest' => $pinterest,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Pinterest  $pinterest
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Pinterest $pinterest) {
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

		return view('socialmedia.pinterests.editPinterest', [
			'userAuth' => $userAuth,
			'accounts' => $accounts,
			'pinterest' => $pinterest,
			]);
		} else {
			return redirect('/');
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Pinterest  $pinterest
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Pinterest $pinterest) {
		$userAuth = Auth::user();

		$pinterest->fill($request->all());
		$pinterest->save();

		return view('socialmedia.pinterests.showPinterest', [
			'pinterest' => $pinterest,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Pinterest  $pinterest
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Pinterest $pinterest) {
		$pinterest->delete();
		return redirect()->action('Socialmedia\\PinterestController@index');
	}

	public function scoreBar($score) {
		if ($score)
			;
	}

}

<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Twitter;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwitterController extends Controller {

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

			$twitters = Twitter::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('account');
					})
					->paginate(20);

			$totalTwitters = $twitters->count();

		$score = $twitters->count();

		return view('socialmedia.twitters.indexTwitters', [
			'twitters' => $twitters,
			'totalTwitters' => $totalTwitters,
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

		return view('socialmedia.twitters.createTwitter', [
			'userAuth' => $userAuth,
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
		Twitter::create($request->all());

		return redirect()->action('Socialmedia\\TwitterController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Twitter  $twitter
	 * @return \Illuminate\Http\Response
	 */
	public function show(Twitter $twitter) {
		$userAuth = Auth::user();

		return view('socialmedia.twitters.showTwitter', [
			'twitter' => $twitter,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Twitter  $twitter
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Twitter $twitter) {
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

		return view('socialmedia.twitters.editTwitter', [
			'userAuth' => $userAuth,
			'accounts' => $accounts,
			'twitter' => $twitter,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Twitter  $twitter
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Twitter $twitter) {
		$userAuth = Auth::user();

		$twitter->fill($request->all());
		$twitter->save();

		return view('socialmedia.twitters.showTwitter', [
			'twitter' => $twitter,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Twitter  $twitter
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Twitter $twitter) {
		$twitter->delete();
		return redirect()->action('Socialmedia\\TwitterController@index');
	}

	public function scoreBar($score) {
		if ($score);
	}
}

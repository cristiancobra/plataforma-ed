<?php

namespace App\Http\Controllers\Socialmedia;

use App\Models\Facebook;
use App\Models\Account;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacebookController extends Controller {

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

			$facebooks = Facebook::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('account');
					})
					->paginate(20);

			$totalFacebooks = $facebooks->count();

			$score = $facebooks->count();

			return view('socialmedia.facebooks.indexFacebooks', [
				'facebooks' => $facebooks,
				'totalFacebooks' => $totalFacebooks,
				'score' => $score,
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
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->get();

		return view('socialmedia.facebooks.createFacebook', [
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
		Facebook::create($request->all());

		return redirect()->action('Socialmedia\\FacebookController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Facebook  $facebook
	 * @return \Illuminate\Http\Response
	 */
	public function show(Facebook $facebook) {
		$userAuth = Auth::user();

		return view('socialmedia.facebooks.showFacebook', [
			'facebook' => $facebook,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Facebook  $facebook
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Facebook $facebook) {
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

			return view('socialmedia.facebooks.editFacebook', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'facebook' => $facebook,
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
	 * @param  \App\Facebook  $facebook
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Facebook $facebook) {
		$userAuth = Auth::user();

		$facebook->fill($request->all());
		$facebook->save();
//		$contact->users()->sync($request->users);

		return view('socialmedia.facebooks.showFacebook', [
			'userAuth' => $userAuth,
			'facebook' => $facebook,
		]);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Facebook  $facebook
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Facebook $facebook) {
		$facebook->delete();
		return redirect()->route('facebook.index');
	}

	public function all() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$facebooks = Facebook::where('id', '>=', 0)
					->orderBy('PAGE_NAME', 'asc')
					->with('account')
					->paginate(40);

			$totalFacebooks = $facebooks->count();

			return view('socialmedia.facebooks.indexFacebooks', [
				'facebooks' => $facebooks,
				'totalFacebooks' => $totalFacebooks,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

}

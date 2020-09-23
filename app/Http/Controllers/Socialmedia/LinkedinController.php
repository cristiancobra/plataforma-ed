<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Linkedin;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkedinController extends Controller {

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

			$linkedins = Linkedin::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('account');
					})
					->paginate(20);

			$totalLinkedin = $linkedins->count();
			
			$score = $twitters->count();

			return view('socialmedia.linkedins.indexLinkedins', [
				'linkedins' => $linkedins,
				'totalLinkedin' => $totalLinkedin,
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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)->with('accounts')->get();
		}

		$linkedin = new Linkedin();

		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.linkedins.createLinkedin', [
			'userAuth' => $userAuth,
			'users' => $users,
			'linkedin' => $linkedin,
			'accounts' => $accounts,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		Linkedin::create($request->all());

		return redirect()->action('Socialmedia\\LinkedinController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Linkedin $linkedin) {
		$userAuth = Auth::user();

		return view('socialmedia.linkedins.showLinkedin', [
			'linkedin' => $linkedin,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Linkedin $linkedin) {
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)->with('accounts')->get();
		}

		$accounts = Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.linkedins.editLinkedin', [
			'userAuth' => $userAuth,
			'users' => $users,
			'accounts' => $accounts,
			'linkedin' => $linkedin,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Linkedin $linkedin) {
		$userAuth = Auth::user();

		$linkedin->fill($request->all());
		$linkedin->save();

		return view('socialmedia.linkedins.showLinkedin', [
			'linkedin' => $linkedin,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Linkedin $linkedin) {
		$linkedin->delete();
		return redirect()->action('Socialmedia\\LinkedinController@index');
	}

}

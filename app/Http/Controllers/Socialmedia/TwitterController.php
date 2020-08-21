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
		if ($userAuth->perfil == "administrador") {
			$twitters = Twitter::where('id', '>=', 0)
					->with('users')
					->orderBy('PAGE_NAME', 'asc')
					->get();
		} else {
			$twitters = Twitter::where('user_id', '=', $userAuth->id)
					->with('users')
					->get();
		}

		$score = $twitters->count();
//		$totalGBs = $emails->sum('storage');

		return view('socialmedia.twitters.indexTwitters', [
			'twitters' => $twitters,
			'userAuth' => $userAuth,
			'score' => $score,
		]);
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

		$twitter = new Twitter();

		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.twitters.createTwitter', [
			'userAuth' => $userAuth,
			'users' => $users,
			'twitter' => $twitter,
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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->get();
		}

		$accounts = Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.twitters.editTwitter', [
			'userAuth' => $userAuth,
			'users' => $users,
			'accounts' => $accounts,
			'twitter' => $twitter,
		]);
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
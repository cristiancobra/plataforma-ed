<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Spotify;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

;

class SpotifyController extends Controller {

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

			$spotifys = Spotify::whereHas('account', function($query) use($accountsID) {
						$query->where('account_id', auth()->user()->account_id)
						->with('account');
					})
					->paginate(20);

			$score = $spotifys->count();

			return view('socialmedia.spotifys.indexSpotifys', [
				'spotifys' => $spotifys,
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
						$query->where('account_id', auth()->user()->account_id);
					})
					->get();

			return view('socialmedia.spotifys.createSpotify', [
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
		Spotify::create($request->all());

		return redirect()->action('Socialmedia\\SpotifyController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Spotify  $spotify
	 * @return \Illuminate\Http\Response
	 */
	public function show(Spotify $spotify) {
		$userAuth = Auth::user();

		return view('socialmedia.spotifys.showSpotify', [
			'spotify' => $spotify,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Spotify  $spotify
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Spotify $spotify) {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereHas('users', function($query) use($accountsID) {
						$query->where('account_id', auth()->user()->account_id);
					})
					->get();


			return view('socialmedia.spotifys.editSpotify', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'spotify' => $spotify,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Spotify  $spotify
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Spotify $spotify) {
		$userAuth = Auth::user();

		$spotify->fill($request->all());
		$spotify->save();

		return view('socialmedia.spotifys.showSpotify', [
			'spotify' => $spotify,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Spotify  $spotify
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Spotify $spotify) {
		$spotify->delete();
		return redirect()->action('Socialmedia\\SpotifyController@index');
	}

	public function scoreBar($score) {
		if ($score)
			;
	}

}

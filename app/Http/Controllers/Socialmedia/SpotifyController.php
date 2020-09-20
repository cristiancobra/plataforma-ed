<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Spotify;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;;

class SpotifyController extends Controller{
/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
		public function index() {
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$spotifys = Spotify::where('id', '>=', 0)
					->with('users')
					->orderBy('PAGE_NAME', 'asc')
					->get();
		} else {
			$spotifys = Spotify::where('user_id', '=', $userAuth->id)
					->with('users')
					->get();
		}

		$score = $spotifys->count();
//		$totalGBs = $emails->sum('storage');

		return view('socialmedia.spotifys.indexSpotifys', [
			'spotifys' => $spotifys,
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

		$spotify = new Spotify();

		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.spotifys.createSpotify', [
			'userAuth' => $userAuth,
			'users' => $users,
			'spotify' => $spotify,
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

		return view('socialmedia.spotifys.editSpotify', [
			'userAuth' => $userAuth,
			'users' => $users,
			'accounts' => $accounts,
			'spotify' => $spotify,
		]);
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
		if ($score);
	}
}

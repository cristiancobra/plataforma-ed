<?php

namespace App\Http\Controllers\Socialmedia;

use App\Http\Controllers\Controller;
use App\Models\Youtube;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class YoutubeController extends Controller
{
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

			$youtubes = Youtube::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('account');
					})
					->paginate(20);

			$totalYoutubes = $youtubes->count();

		$score = $youtubes->count();

		return view('socialmedia.youtubes.indexYoutubes', [
			'youtubes' => $youtubes,
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

		return view('socialmedia.youtubes.createYoutube', [
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
		Youtube::create($request->all());

		return redirect()->action('Socialmedia\\YoutubeController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function show(Youtube $youtube) {
		$userAuth = Auth::user();

		return view('socialmedia.youtubes.showYoutube', [
			'youtube' => $youtube,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Youtube $youtube) {
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

		return view('socialmedia.youtubes.editYoutube', [
			'userAuth' => $userAuth,
			'accounts' => $accounts,
			'youtube' => $youtube,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Youtube $youtube) {
		$userAuth = Auth::user();

		$youtube->fill($request->all());
		$youtube->save();

		return view('socialmedia.youtubes.showYoutube', [
			'youtube' => $youtube,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Youtube  $youtube
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Youtube $youtube) {
		$youtube->delete();
		return redirect()->action('Socialmedia\\YoutubeController@index');
	}

	public function scoreBar($score) {
		if ($score);
	}
}

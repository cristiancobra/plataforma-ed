<?php

namespace App\Http\Controllers\Socialmedia;

use App\Models\Instagram;
use App\Models\Account;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstagramController extends Controller {

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

			$instagrams = Instagram::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID)
						->with('account');
					})
					->paginate(20);

			$totalInstagrams = $instagrams->count();


			return view('socialmedia.instagrams.indexInstagrams', [
				'instagrams' => $instagrams,
				'totalInstagrams' => $totalInstagrams,
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

			$instagrams = Instagram::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->paginate(20);

			return view('socialmedia.instagrams.createInstagram', [
				'userAuth' => $userAuth,
				'instagrams' => $instagrams,
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
		Instagram::create($request->all());

		return redirect()->action('Socialmedia\\InstagramController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Instagram  $instagram
	 * @return \Illuminate\Http\Response
	 */
	public function show(Instagram $instagram) {
		$userAuth = Auth::user();

		return view('socialmedia.instagrams.showInstagram', [
			'instagram' => $instagram,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Instagram  $instagram
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Instagram $instagram) {
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

			return view('socialmedia.instagrams.editInstagram', [
				'userAuth' => $userAuth,
				'instagram' => $instagram,
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
	 * @param  \App\Instagram  $instagram
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Instagram $instagram) {
		$userAuth = Auth::user();

		$instagram->user_id = ($request->user_id);
		$instagram->page_name = ($request->page_name);
		$instagram->URL_name = ($request->URL_name);
		$instagram->business = ($request->business);
		$instagram->linked_facebook = ($request->linked_facebook);
		$instagram->same_site_name = ($request->same_site_name);
		$instagram->about = ($request->about);
		$instagram->linktree = ($request->linktree);
		$instagram->feed_content = ($request->feed_content);
		$instagram->harmonic_feed = ($request->harmonic_feed);
		$instagram->SEO_descriptions = ($request->SEO_descriptions);
		$instagram->feed_images = ($request->feed_images);
		$instagram->stories = ($request->stories);
		$instagram->interaction = ($request->interaction);
		$instagram->value_ads = ($request->value_ads);
		$instagram->status = ($request->status);
		$instagram->save();

		return view('socialmedia.instagrams.showInstagram', [
			'userAuth' => $userAuth,
			'instagram' => $instagram,
				//'emails' => $emails,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Instagram  $instagram
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Instagram $instagram) {
		$instagram->delete();
		return redirect()->route('instagram.index');
	}

}

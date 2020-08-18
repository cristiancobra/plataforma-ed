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
		if ($userAuth->perfil == "administrador") {
			$instagrams = Instagram::where('id', '>=', 0)->with('users')->orderBy('PAGE_NAME', 'asc')->get();
			$totalInstagrams = $instagrams->count();
		} else {
			$instagrams = Instagram::where('user_id', '=', $userAuth->id)->with('users')->get();
		}

	//	$accounts = Account::where('id', '=', $user->id)->with('users')->get();

		return view('socialmedia.instagrams.indexInstagrams', [
			'instagrams' => $instagrams,
	//		'accounts' => $accounts,
			'totalInstagrams' => $totalInstagrams,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$instagram = new \App\Models\Instagram();
		$userAuth = Auth::user();
		$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.instagrams.createInstagram', [
			'userAuth' => $userAuth,
			'users' => $users,
			'instagram' => $instagram,
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
		$instagram = new \App\Models\Instagram();
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

		$instagrams = \App\Models\Instagram::all();
		$userAuth = Auth::user();

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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
			$totalUsers = $users->count();
		} else {
			$users = User::where('id', '=', $userAuth->id)->with('accounts')->first();
			$totalUsers = $users->count();
		}
		$instagrams = Instagram::where('id', '=', $user->id)->with('users')->get();
//		$accounts = User::where('id', '=', $user->id)->with('accounts')->get();

		return view('socialmedia.instagrams.showInstagram', [
			'instagram' => $instagram,
			'instagrams' => $instagrams,
			'userAuth' => $userAuth,
			'users' => $users,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Instagram  $instagram
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Instagram $instagram) {
		$user = Auth::user();
		$instagrams = Instagram::all();

		if ($user->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
			$instagrams = Instagram::where('id', '>=', 0)->orderBy('PAGE_NAME', 'asc')->get();
			$totalInstagrams = $instagrams->count();
		} else {
			$users = User::where('id', '=', $user->id)->with('accounts')->first();
			$instagrams = Instagram::where('user_id', '=', $user->id)->with('users')->get();
			$totalInstagrams = $instagrams->count();
		}

		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('socialmedia.instagrams.editInstagram', [
			'user' => $user,
			'users' => $users,
			'instagram' => $instagram,
			'instagrams' => $instagrams,
			'accounts' => $accounts,
			'totalEmails' => $totalInstagrams,
		]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Instagram  $instagram
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Instagram $instagram) {
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
		
		$user = Auth::user();

		return view('socialmedia.instagrams.showInstagram', [
			'user' => $user,
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

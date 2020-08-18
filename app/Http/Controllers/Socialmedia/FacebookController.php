<?php

namespace App\Http\Controllers\Socialmedia;

use App\Models\Facebook;
use App\Models\Account;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$facebooks = Facebook::where('id', '>=', 0)->with('users')->orderBy('PAGE_NAME', 'asc')->get();
			$totalFacebooks = $facebooks->count();
		} else {
			$facebooks = Facebook::where('user_id', '=', $userAuth->id)->with('users')->get();
		}

		$accounts = Account::where('id', '=', $userAuth->id)->with('users')->get();

		return view('facebooks.indexFacebooks', [
			'facebooks' => $facebooks,
			'accounts' => $accounts,
			'totalFacebooks' => $totalFacebooks,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$facebook = new \App\Models\Facebook();
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)->with('accounts')->get();
		}
		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('facebooks.createFacebook', [
			'userAuth' => $userAuth,
			'users' => $users,
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
		$facebook = new \App\Models\Facebook();
		$facebook->user_id = ($request->user_id);
		$facebook->page_name = ($request->page_name);
		$facebook->URL_name = ($request->URL_name);
		$facebook->linked_instagram = ($request->linked_instagram);
		$facebook->same_site_name = ($request->same_site_name);
		$facebook->about = ($request->about);
		$facebook->feed_content = ($request->feed_content);
		$facebook->harmonic_feed = ($request->harmonic_feed);
		$facebook->SEO_descriptions = ($request->SEO_descriptions);
		$facebook->feed_images = ($request->feed_images);
		$facebook->stories = ($request->stories);
		$facebook->interaction = ($request->interaction);
		$facebook->value_ads = ($request->value_ads);
		$facebook->status = ($request->status);
		$facebook->save();

		$facebooks = \App\Models\Facebook::all();
		$userAuth = Auth::user();

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
		if ($userAuth->perfil == "administrador") {
			$userAuths = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
			$totalUsers = $userAuths->count();
		} else {
			$userAuths = User::where('id', '=', $userAuth->id)->with('accounts')->first();
			$totalUsers = $userAuth->count();
		}
		$facebooks = Facebook::where('id', '=', $userAuth->id)->with('users')->get();
//		$accounts = User::where('id', '=', $userAuth->id)->with('accounts')->get();

		return view('facebooks.showFacebook', [
			'facebook' => $facebook,
			'facebooks' => $facebooks,
			'userAuth' => $userAuth,
			'users' => $userAuth,
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
		$facebooks = Facebook::all();

		if ($userAuth->perfil == "administrador") {
			$userAuths = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
			$facebooks = Facebook::where('id', '>=', 0)->orderBy('PAGE_NAME', 'asc')->get();
			$totalFacebooks = $facebooks->count();
		} else {
			$userAuths = User::where('id', '=', $userAuth->id)->with('accounts')->first();
			$facebooks = Facebook::where('user_id', '=', $userAuth->id)->with('users')->get();
			$totalFacebooks = $facebooks->count();
		}

		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('facebooks.editFacebook', [
			'userAuth' => $userAuth,
			'users' => $userAuths,
			'facebook' => $facebook,
			'facebooks' => $facebooks,
			'accounts' => $accounts,
			'totalEmails' => $totalFacebooks,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Facebook  $facebook
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Facebook $facebook) {
		$facebook->user_id = ($request->user_id);
		$facebook->page_name = ($request->page_name);
		$facebook->URL_name = ($request->URL_name);
		$facebook->linked_instagram = ($request->linked_instagram);
		$facebook->same_site_name = ($request->same_site_name);
		$facebook->about = ($request->about);
		$facebook->feed_content = ($request->feed_content);
		$facebook->harmonic_feed = ($request->harmonic_feed);
		$facebook->SEO_descriptions = ($request->SEO_descriptions);
		$facebook->feed_images = ($request->feed_images);
		$facebook->stories = ($request->stories);
		$facebook->interaction = ($request->interaction);
		$facebook->value_ads = ($request->value_ads);
		$facebook->status = ($request->status);
		$facebook->save();
		
		$userAuth = Auth::user();

		return view('facebooks.showFacebook', [
			'userAuth' => $userAuth,
			'facebook' => $facebook,
				//'emails' => $emails,
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
}

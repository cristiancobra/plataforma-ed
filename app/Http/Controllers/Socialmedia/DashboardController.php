<?php

namespace App\Http\Controllers\Socialmedia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use App\Lead;
use App\Models\Task;
use App\Models\Account;
use App\Opportunities;
use App\Models\Facebook;
use App\Models\Instagram;
use App\Models\Linkedin;
use App\Models\Twitter;
use App\Models\Pinterest;
use App\Models\Youtube;
use App\Models\Spotify;

class DashboardController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function socialmedia() {
		$userAuth = Auth::user();
		$hoje = date("d/m/Y");

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$facebooks = Facebook::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		$instagrams = Instagram::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		$linkedins = Linkedin::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		$twitters = Twitter::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		$pinterests = Pinterest::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		$youtubes = Youtube::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		$spotifys = Spotify::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID)
					->with('account');
				})
				->get();

		return view('socialmedia/dashboardSocialmedia', [
			'userAuth' => $userAuth,
			'hoje' => $hoje,
			'facebooks' => $facebooks,
			'instagrams' => $instagrams,
			'linkedins' => $linkedins,
			'twitters' => $twitters,
			'pinterests' => $pinterests,
			'youtubes' => $youtubes,
			'spotify' => $spotifys,
		]);
	}

}

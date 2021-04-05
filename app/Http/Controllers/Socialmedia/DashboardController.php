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
		$hoje = date("d/m/Y");

		$facebooks = Facebook::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		$instagrams = Instagram::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		$linkedins = Linkedin::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		$twitters = Twitter::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		$pinterests = Pinterest::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		$youtubes = Youtube::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		$spotifys = Spotify::whereHas('account', function($query) {
					$query->whereIn('account_id', userAccounts())
					->with('account');
				})
				->get();

		return view('socialmedia/dashboardSocialmedia', compact(
			'hoje',
			'facebooks',
			'instagrams',
			'linkedins',
			'twitters',
			'pinterests',
			'youtubes',
			'spotifys',
		));
	}

}

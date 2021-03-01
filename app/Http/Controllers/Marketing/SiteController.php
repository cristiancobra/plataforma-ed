<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$sites = Site::whereIn('account_id', userAccounts())
				->with('domains')
				->orderBy('NAME', 'ASC')
				->paginate(20);

		$totalSites = $sites->count();

		return view('marketing.sites.index', compact(
						'sites',
						'totalSites',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
			$site = new Site();

			$accounts = Account::whereIn('id', userAccounts())
					->orderBy('NAME', 'ASC')
					->get();

			return view('marketing.sites.create', compact(
				'site',
				'accounts',
			));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		Site::create($request->all());

		return redirect()->action('Marketing\\SiteController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Site  $site
	 * @return \Illuminate\Http\Response
	 */
	public function show(Site $site) {

		return view('marketing.sites.show', compact(
			'site',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Site  $site
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Site $site) {
		$accounts = Account::whereHas('users', function($query) {
					$query->whereIn('account_id', userAccounts());
				})
				->get();

		return view('marketing.sites.edit', compact(
						'site',
						'accounts',
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Site  $site
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Site $site) {

		$site->fill($request->all());
		$site->save();

		return view('marketing.sites.show', compact(
						'site',
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Site  $site
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Site $site) {
		$site->delete();
		return redirect()->action('Marketing\\SiteController@index');
	}

}

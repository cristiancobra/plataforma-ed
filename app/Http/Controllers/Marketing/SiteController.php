<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$sites = Site::whereIn('account_id', $accountsID)
					->with('domains')
					->orderBy('NAME', 'ASC')
					->paginate(20);
//dd($sites);
			$totalSites = $sites->count();

			return view('marketing.sites.indexSites', [
				'sites' => $sites,
				'totalSites' => $totalSites,
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
    public function create()
    {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$site = new Site();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			return view('marketing.sites.createSite', [
				'userAuth' => $userAuth,
				'site' => $site,
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
    public function store(Request $request)
    {
		Site::create($request->all());

		return redirect()->action('Marketing\\SiteController@index');
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
		$userAuth = Auth::user();

			return view('marketing.sites.showSite', [
			'site' => $site,
			'userAuth' => $userAuth,
		]);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
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

			return view('marketing.sites.editSite', [
				'userAuth' => $userAuth,
				'site' => $site,
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
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
		$userAuth = Auth::user();

		$site->fill($request->all());
		$site->save();

			return view('marketing.sites.showSite', [
			'site' => $site,
			'userAuth' => $userAuth,
		]);
	}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
		$site->delete();
		return redirect()->action('Marketing\\SiteController@index');
	}
}
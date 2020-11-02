<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Domain;
use App\Models\Site;
use Illuminate\Http\Request;

class DomainController extends Controller
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
					->get('id');

			$domains = Domain::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->paginate(20);

			$totalDomains = $domains->count();

			return view('marketing.domains.indexDomains', [
				'domains' => $domains,
				'totalDomains' => $totalDomains,
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
			$domain = new Domain();

			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$accounts = Account::whereIn('id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			$sites = Site::whereIn('account_id', $accountsID)
					->orderBy('NAME', 'ASC')
					->get();

			return view('marketing.domains.createDomain', [
				'userAuth' => $userAuth,
				'domain' => $domain,
				'sites' => $sites,
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
		Domain::create($request->all());

		return redirect()->action('Marketing\\DomainController@index');
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain)
    {
		$userAuth = Auth::user();

		return view('marketing.domains.showDomain', [
			'domain' => $domain,
			'userAuth' => $userAuth,
		]);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
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

			return view('marketing.domains.editDomain', [
				'userAuth' => $userAuth,
				'domain' => $domain,
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
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain)
    {
    {
		$userAuth = Auth::user();

		$domain->fill($request->all());
		$domain->save();

			return view('marketing.domains.showDomain', [
			'domain' => $domain,
			'userAuth' => $userAuth,
		]);
	}
	}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
		$domain->delete();
		return redirect()->action('Marketing\\DomainController@index');
	}
}

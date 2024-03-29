<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Domain;
use App\Models\Site;
use Illuminate\Http\Request;

class DomainController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $domains = Domain::where('account_id', auth()->user()->account_id)
                ->with(['site', 'contact'])
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $domains->count();

        return view('marketing.domains.index', compact(
                        'domains',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $sites = Site::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('marketing.domains.create', compact(
                        'contacts',
                        'sites',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        Domain::create($request->all());

        return redirect()->action('Marketing\\DomainController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain) {
        $sites = Site::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('marketing.domains.show', compact(
                        'domain',
                        'sites',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain) {
        $accounts = Account::whereHas('users', function ($query) {
                    $query->where('account_id', auth()->user()->account_id);
                })
                ->get();

        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $sites = Site::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        return view('marketing.domains.edit', compact(
                        'domain',
                        'accounts',
                        'contacts',
                        'sites',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domain $domain) { {
            $domain->fill($request->all());
            $domain->save();

            $sites = Site::where('account_id', auth()->user()->account_id)
                    ->orderBy('NAME', 'ASC')
                    ->get();

            return view('marketing.domains.show', compact(
                            'domain',
                            'sites',
            ));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain) {
        $domain->delete();
        return redirect()->action('Marketing\\DomainController@index');
    }

}

<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Campaign;
use App\Models\Email;
use Illuminate\Http\Request;

class CampaignController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $accounts = userAccounts();

        $campaigns = Campaign::whereIn('account_id', userAccounts())
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $campaigns->total();

        return view('marketing.campaign.index', compact(
                        'accounts',
                        'campaigns',
                        'total'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $campaign = new Campaign;

        $accounts = Account::whereIn('id', userAccounts())
                ->get();

        $emails = Email::whereIn('account_id', userAccounts())
                ->orderBy('TITLE', 'ASC')
                ->paginate(20);

        $users = myUsers();

        return view('marketing.campaign.create', compact(
                        'accounts',
                        'campaign',
                        'users',
                        'emails',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign) {
        //
    }

}

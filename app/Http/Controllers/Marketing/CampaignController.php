<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Marketing;
use App\Models\Account;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Email;
use Mail;

class CampaignController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $accounts = userAccounts();

        $campaigns = Campaign::whereIn('account_id', userAccounts())
                ->with(
                        'account',
                        'user.contact',
                        'email'
                )
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
        $accounts = Account::whereIn('id', userAccounts())
                ->get();

        $emails = Email::whereIn('account_id', userAccounts())
                ->orderBy('TITLE', 'ASC')
                ->paginate(20);

        $users = myUsers();

        return view('marketing.campaign.create', compact(
                        'accounts',
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
        $campaign = new Campaign;
        $campaign->fill($request->all());
        $campaign->save();

        return view('marketing.campaign.show', compact(
                        'campaign',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign) {
        $accounts = Account::whereIn('id', userAccounts())
                ->get();

        $account = Account::find(1);

        $contact = Contact::find(5);

        $users = myUsers();

        $emails = Email::whereIn('account_id', userAccounts())
                ->orderBy('TITLE', 'ASC')
                ->paginate(20);

        return view('marketing.campaign.show', compact(
                        'campaign',
                        'accounts',
                        'account',
                        'contact',
                        'users',
                        'emails',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign) {
        $accounts = Account::whereIn('id', userAccounts())
                ->get();

        $emails = Email::whereIn('account_id', userAccounts())
                ->orderBy('TITLE', 'ASC')
                ->paginate(20);

        $users = myUsers();

        return view('marketing.campaign.edit', compact(
                        'accounts',
                        'users',
                        'emails',
                        'campaign',
        ));
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

    // Dispara campanhas de email agendadas
    public function send(Request $request) {

        $data = [
            'accountName' => $request->account_name,
            'contactName' => $request->contact_name,
            'contactEmail' => $request->contact_email,
        ];

        Mail::send(new Marketing($data));

        echo 'Email enviado com sucesso!';
//		return view('emails.marketing', compact(
//								'email',
//								'contact',
//		));
    }

}

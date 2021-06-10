<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\User;

class ContactController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $accountsId = userAccounts();

        $contacts = Contact::whereHas('account', function ($query) use ($accountsId) {
                    $query->whereIn('account_id', $accountsId);
                })
                ->whereHas('account', function ($query) use ($request) {
                    if (isset($request->account_id)) {
                        $query->where('account_id', '=', $request->account_id);
                    } else {
                        $query->where('accounts.id', '>', 0);
                    }
                })
                ->where(function ($query) use ($request) {
                    if ($request->name) {
                        $query->where('name', 'like', "%$request->name%");
                    }
                })
                ->with('opportunities', 'companies', 'user')
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $accounts = Account::whereIn('id', $accountsId)
                ->orderBy('ID', 'ASC')
                ->get();

        $total = $contacts->total();

        return view('contacts.indexContacts', compact(
                        'contacts',
                        'accounts',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $contacts = Contact::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->paginate(20);

        $companies = Company::whereHas('account', function ($query) {
                    $query->whereIn('account_id', userAccounts());
                })
                ->get();

        $states = returnStates();

        return view('contacts.createContact', compact(
                        'contacts',
                        'states',
                        'companies',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $contact = new Contact();
        $contact->fill($request->all());
        $contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);

        $messages = [
            'unique' => 'Já existe um contato com este :attribute.',
            'required' => '*preenchimento obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required:tasks',
                    'last_name' => 'required:tasks',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $contact->account_id = auth()->user()->account_id;
            $contact->save();
            $contact->companies()->sync($request->companies);
        }

        return redirect()->action('Contact\\ContactController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact) {

        return view('contacts.showContact', [
            'contact' => $contact,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact) {
        $accountsId = userAccounts();
        
        $companies = Company::whereHas('account', function ($query) use ($accountsId) {
                    $query->whereIn('account_id', $accountsId);
                })
                ->get();

        $companiesChecked = Company::whereHas('contacts', function ($query) use ($contact) {
                    $query->where('contact_id', $contact->id);
                })
                ->pluck('id')
                ->toArray();

        $states = returnStates();

        return view('contacts.editContact', compact(
                        'accounts',
                        'contact',
                        'companies',
                        'companiesChecked',
                        'states',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact) {
        $contact->fill($request->all());
        $contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);
        $contact->save();
        $contact->companies()->sync($request->companies);

        return view('contacts.showContact', [
            'contact' => $contact,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact) {
        $contact->delete();
        return redirect()->route('contact.index');
    }

}

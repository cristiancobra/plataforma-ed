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
	public function index() {
		$accountsId = userAccounts();

		$contacts = Contact::whereHas('account', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->with('opportunities', 'companies','user')
				->orderBy('NAME', 'ASC')
				->paginate(20);
//dd($contacts);
		$totalContacts = $contacts->count();

		return view('contacts.indexContacts', [
			'contacts' => $contacts,
			'totalContacts' => $totalContacts,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$contact = new Contact();

		$accountsId = userAccounts();

		$accounts = Account::whereHas('users', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		$contacts = Contact::whereHas('account', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->paginate(20);

		$companies = Company::whereHas('account', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->paginate(20);

		$states = returnStates();

		return view('contacts.createContact', compact(
						'contact',
						'contacts',
						'accounts',
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

		$accounts = Account::whereHas('users', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		$companies = Company::whereHas('account', function($query) use($accountsId) {
					$query->whereIn('account_id', $accountsId);
				})
				->get();

		$companiesChecked = Company::whereHas('contacts', function($query) use($contact) {
					$query->where('contact_id', $contact->id);
				})
				->pluck('id')
				->toArray();

		$states = returnStates();

		return view('contacts.editContact', compact(
						'accounts',
						'contact',
						'accounts',
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

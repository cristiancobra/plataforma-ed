<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ContactController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$contacts = Contact::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->paginate(20);

		$totalContacts = $contacts->count();

		return view('contacts.indexContacts', [
			'contacts' => $contacts,
			'totalContacts' => $totalContacts,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$userAuth = Auth::user();
		$contact = new Contact();

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$accounts = Account::whereHas('users', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->get();

		$contacts = Contact::whereHas('account', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->paginate(20);

		return view('contacts.createContact', [
			'userAuth' => $userAuth,
			'contact' => $contact,
			'contacts' => $contacts,
			'accounts' => $accounts,
		]);
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
		$contact->save();
		$contact->users()->sync($request->users);
		$contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);

		return redirect()->action('Contact\\ContactController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Contact  $contact
	 * @return \Illuminate\Http\Response
	 */
	public function show(Contact $contact) {
		$userAuth = Auth::user();

		return view('contacts.showContact', [
			'contact' => $contact,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contact  $contact
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contact $contact) {
		$userAuth = Auth::user();

		$accountsID = Account::whereHas('users', function($query) use($userAuth) {
					$query->where('users.id', $userAuth->id);
				})
				->pluck('id');

		$accounts = Account::whereHas('users', function($query) use($accountsID) {
					$query->whereIn('account_id', $accountsID);
				})
				->get();

		return view('contacts.editContact', [
			'userAuth' => $userAuth,
			'accounts' => $accounts,
			'contact' => $contact,
			'accounts' => $accounts,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Contact  $contact
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Contact $contact) {
		$userAuth = Auth::user();

		$contact->fill($request->all());
		$contact->save();
		$contact->users()->sync($request->users);

		return view('contacts.showContact', [
			'userAuth' => $userAuth,
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

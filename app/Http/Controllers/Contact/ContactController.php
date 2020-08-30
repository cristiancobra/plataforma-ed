<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
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
		if ($userAuth->perfil == "administrador") {
			$contacts = Contact::where('id', '>=', 0)
					->with('users')
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$contacts = Contact::where('user_id', '=', $userAuth->id)
					->with('users')
					->get();
		}
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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->get();
		}
		$contacts = Contact::where('id', '>=', 0)
				->orderBy('NAME', 'asc')
				->get();

		return view('contacts.createContact', [
			'userAuth' => $userAuth,
			'users' => $users,
			'contact' => $contact,
			'contacts' => $contacts,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$userAuth = Auth::user();

		$contact = new Contact();
		$contact->fill($request->all());
		$contact->save();
		$contact->users()->sync($request->users);

		return redirect()->action('Accounts\\AccountController@index');
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
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->get();
		}
//
////		$idsAccount = $account->users->toArray();
//		$idsAccount = Account::find($account->id)
//				->with('users')
//				->orderBy('NAME', 'asc')
//				->get();

		return view('accounts.editAccount', [
			'userAuth' => $userAuth,
			'users' => $users,
//			'account' => $account,
//			'idsAccount' => $idsAccount,
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Contact  $contact
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Contact $contact) {
		//
	}

}

<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ContactController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userAuth = Auth::user();

		if (Auth::check()) {
			$accountsID = Account::whereHas('users', function($query) use($userAuth) {
						$query->where('users.id', $userAuth->id);
					})
					->pluck('id');

			$contacts = Contact::whereHas('account', function($query) use($accountsID) {
						$query->whereIn('account_id', $accountsID);
					})
					->orderBy('NAME', 'ASC')
					->paginate(20);

			$totalContacts = $contacts->count();

			return view('contacts.indexContacts', [
				'contacts' => $contacts,
				'totalContacts' => $totalContacts,
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
	public function create() {
		$userAuth = Auth::user();
		$contact = new Contact();

		if (Auth::check()) {
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
					
						$states = array(
				'AC' => 'Acre',
				'AL' => 'Alagoas',
				'AP' => 'Amapá',
				'AM' => 'Amazonas',
				'BA' => 'Bahia',
				'CE' => 'Ceará',
				'DF' => 'Distrito Federal',
				'ES' => 'Espirito Santo',
				'GO' => 'Goiás',
				'MA' => 'Maranhão',
				'MS' => 'Mato Grosso do Sul',
				'MT' => 'Mato Grosso',
				'MG' => 'Minas Gerais',
				'PA' => 'Pará',
				'PB' => 'Paraíba',
				'PR' => 'Paraná',
				'PE' => 'Pernambuco',
				'PI' => 'Piauí',
				'RJ' => 'Rio de Janeiro',
				'RN' => 'Rio Grande do Norte',
				'RS' => 'Rio Grande do Sul',
				'RO' => 'Rondônia',
				'RR' => 'Roraima',
				'SC' => 'Santa Catarina',
				'SP' => 'São Paulo',
				'SE' => 'Sergipe',
				'TO' => 'Tocantins',
			);

			return view('contacts.createContact', [
				'userAuth' => $userAuth,
				'contact' => $contact,
				'contacts' => $contacts,
				'accounts' => $accounts,
				'states' => $states,
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
	public function store(Request $request) {
		$contact = new Contact();
		$contact->fill($request->all());
		$contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);

		$messages = [
			'unique' => 'Já existe um contato com este :attribute.',
			'required' => '*preenchimento obrigatório.',
		];
		$validator = Validator::make($request->all(), [
					'email' => 'unique:emails',
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
		$userAuth = Auth::user();

		if (Auth::check()) {
			return view('contacts.showContact', [
				'contact' => $contact,
				'userAuth' => $userAuth,
			]);
		} else {
			return redirect('/');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Contact  $contact
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contact $contact) {
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

			$states = array(
				'AC' => 'Acre',
				'AL' => 'Alagoas',
				'AP' => 'Amapá',
				'AM' => 'Amazonas',
				'BA' => 'Bahia',
				'CE' => 'Ceará',
				'DF' => 'Distrito Federal',
				'ES' => 'Espirito Santo',
				'GO' => 'Goiás',
				'MA' => 'Maranhão',
				'MS' => 'Mato Grosso do Sul',
				'MT' => 'Mato Grosso',
				'MG' => 'Minas Gerais',
				'PA' => 'Pará',
				'PB' => 'Paraíba',
				'PR' => 'Paraná',
				'PE' => 'Pernambuco',
				'PI' => 'Piauí',
				'RJ' => 'Rio de Janeiro',
				'RN' => 'Rio Grande do Norte',
				'RS' => 'Rio Grande do Sul',
				'RO' => 'Rondônia',
				'RR' => 'Roraima',
				'SC' => 'Santa Catarina',
				'SP' => 'São Paulo',
				'SE' => 'Sergipe',
				'TO' => 'Tocantins',
			);
			
			return view('contacts.editContact', [
				'userAuth' => $userAuth,
				'accounts' => $accounts,
				'contact' => $contact,
				'accounts' => $accounts,
				'states' => $states,
			]);
		} else {
			return redirect('/');
		}
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
//		dd($contact);
		$contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);
		$contact->save();
//		$contact->users()->sync($request->users);

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

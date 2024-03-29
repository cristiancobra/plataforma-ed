<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Email;
use App\Models\User;
use App\Mail\marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {

		$emails = Email::where('account_id', auth()->user()->account_id)
				->with('user', 'account')
				->get();

		$total = $emails->count();
		$totalGBs = $emails->sum('storage');

		return view('emails.index', compact(
						'emails',
						'total',
						'totalGBs',
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$contacts = Contact::where('account_id', auth()->user()->account_id)
				->orderBy('NAME', 'ASC')
				->get();

		return view('emails.create', compact(
						'accounts',
						'contacts',
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$email = new Email();
		$email->fill($request->all());
		$email->save();

//		return redirect()->action('Emails\\EmailController@index');

		return view('emails.show', compact(
						'email',
		));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function show(Email $email) {

		return view('emails.show', compact(
						'email',
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Email $email, Request $request) {
		$users = User::myUsers();

		return view('emails.edit', compact(
						'users',
						'email',
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Email $email) {
		$email->fill($request->all());
		$email->save();

		return view('emails.show', compact(
						'email',
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Email $email) {
		$email->delete();
		return redirect()->route('emails.index');
	}

	public function send(Email $email) {
		$account = Account::find($email->account_id);
		$contact = Contact::find(5);

		Mail::send(new marketing($account,$contact, $email));
		
		echo 'Email enviado com sucesso!';
//		return view('emails.marketing', compact(
//								'email',
//								'contact',
//		));
	}

}

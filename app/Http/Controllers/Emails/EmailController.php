<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		if ($user->perfil == "administrador") {
			$emails = Email::where('id', '>=', 0)->orderBy('EMAIL', 'asc')->get();
			$totalEmails = $emails->count();
		} else {
			$emails = Email::where('user_id', '=', $user->id)->with('users')->get();
		}

		return view('emails.listAllEmails', [
			'emails' => $emails,
			'totalEmails' => $totalEmails,
			'user' => $user,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$email = new \App\Models\Email();
		$user = Auth::user();
		$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		$accounts = \App\Models\Account::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		return view('emails.createEmail', [
			'user' => $user,
			'users' => $users,
			'email' => $email,
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
		$email = new \App\Models\Email();
		$email->user_id = ($request->user_id);
		$email->email = ($request->email);
		$email->email_password = ($request->email_password);
		$email->storage = ($request->storage);
		$email->status = "pendente";
		$email->save();

		$emails = \App\Models\Email::all();
		$user = Auth::user();

		return redirect()->action('Emails\\EmailController@index');
		
//		return view('emails.listAllEmails', [
//			'user' => $user,
//			'user_id' => $email->user_id,
//			'account_id' => $email->account_id,
//			'email' => $email->email,
//			'password' => $email->email_password,
//			'status' => $email->status,
//			'emails' => $emails,
//		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function show(Email $email) {
		$user = Auth::user();
		$emails = Email::where('id', '=', $user->id)->with('users')->get();
		//	$accounts = User::where('id', '=', $user->id)->with('accounts')->get();
		return view('emails.detailsEmail', [
			'email' => $email,
			'emails' => $emails,
			'user' => $user,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Email $email) {
		$user = Auth::user();
		$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();
		$emails = Email::all();
		return view('emails.editEmail', [
			'user' => $user,
			'users' => $users,
			'email' => $email,
			'emails' => $emails,
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Email $email) {
		$email->email = $request->email;
		//$user->name = $request->name;
		$email->email_password = $request->email_password;
		$email->storage = $request->storage;
		$email->status = $request->status;
		$email->save();
		
		$user = Auth::user();

		return view('emails.detailsEmail', [
			'user' => $user,
			'email' => $email,
			//'emails' => $emails,
		]);
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

}

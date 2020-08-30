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
		$userAuth = Auth::user();
		if ($userAuth->perfil == "administrador") {
			$emails = Email::where('id', '>=', 0)
					->with('users')
					->orderBy('EMAIL', 'asc')
					->get();
		} else {
			$emails = Email::where('user_id', '=', $userAuth->id)
					->with('users')
					->get();
		}
		$totalEmails = $emails->count();
		$totalGBs = $emails->sum('storage');

		return view('emails.indexEmails', [
			'emails' => $emails,
			'totalEmails' => $totalEmails,
			'totalGBs' => $totalGBs,
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
		$email = new \App\Models\Email();
		if ($userAuth->perfil == "administrador") {
			$users = User::where('id', '>=', 0)
					->orderBy('NAME', 'asc')
					->get();
		} else {
			$users = User::where('id', '=', $userAuth->id)
					->with('accounts')
					->get();
		}
		$accounts = \App\Models\Account::where('id', '>=', 0)
				->orderBy('NAME', 'asc')
				->get();

		return view('emails.createEmail', [
			'userAuth' => $userAuth,
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
		$userAuth = Auth::user();

		return redirect()->action('Emails\\EmailController@index');

//		return view('emails.indexEmails', [
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
		$userAuth = Auth::user();

		return view('emails.showEmail', [
			'email' => $email,
			'userAuth' => $userAuth,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Email  $email
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Email $email) {
		$userAuth = Auth::user();
		$users = User::where('id', '>=', 0)->orderBy('NAME', 'asc')->get();

		if ($userAuth->perfil == "administrador") {
			$emails = Email::where('id', '>=', 0)->orderBy('EMAIL', 'asc')->get();
		} else {
			$emails = Email::where('user_id', '=', $userAuth->id)->with('users')->get();
		}

		return view('emails.editEmail', [
			'userAuth' => $userAuth,
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
		$userAuth = Auth::user();
		$email->email = $request->email;
		//$user->name = $request->name;
		$email->email_password = $request->email_password;
		$email->storage = $request->storage;
		$email->status = $request->status;
		$email->save();

		return view('emails.showEmail', [
			'userAuth' => $userAuth,
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

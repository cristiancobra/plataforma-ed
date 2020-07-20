<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Models\EmailModel;
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
		$emails = EmailModel::all();
		$user = Auth::user();

		return view('emails.listAllEmails', [
			'emails' => $emails,
			'user' => $user,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$email = new \App\Models\EmailModel();
		$user = Auth::user();
		$users = User::all()->get();
		
		return view('emails.createEmail', [
			'user' => $user,
			'users' => $users,
			'email' => $email,
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$email = new \App\Models\EmailModel();
		$email->user_id = ($request->user_id);
		$email->account_id = ($request->account_id);
		$email->perfil_id = ($request->perfil_id);
		$email->email = ($request->email);
		$email->email_password = ($request->password);
		$email->status = "desativado";
		$email->save();

		$emails = \App\Models\EmailModel::all();
		$user = Auth::user();

		return view('emails.listAllEmails', [
			'user' => $user,
			'user_id' => $email->user_id,
			'account_id' => $email->account_id,
			'perfil_id' => $email->perfil_id,
			'email' => $email->email,
			'password' => $email->email_password,
			'status' => $email->status,
			'emails' => $emails,
			
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\EmailModel  $emailModel
	 * @return \Illuminate\Http\Response
	 */
	public function show(EmailModel $emailModel) {
//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\EmailModel  $emailModel
	 * @return \Illuminate\Http\Response
	 */
	public function edit(EmailModel $emailModel) {
//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\EmailModel  $emailModel
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, EmailModel $emailModel) {
//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\EmailModel  $emailModel
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(EmailModel $emailModel) {
//
	}

}

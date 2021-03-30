<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Campaign;
use App\Models\Email;

class Marketing extends Mailable {

	use Queueable,
	 SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct() {
//            dd($data);
//		$this->account = $request->account;
//		$this->contact = $request->contact;
//		$this->email = $request->email;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(Request $request) {
		$contact = Contact::find($request->contact);
		$account = Account::find($request->account);
		$email = Email::find($request->email);

		$this->subject($email->title);
		$this->to($contact->email, $contact->name);

		return $this->markdown('emails.marketing', compact(
								'account',
								'email',
								'contact',
		));
	}

}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Email;

class marketing extends Mailable {

	use Queueable,
	 SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Account $account, Contact $contact, Email $email) {
		$this->contact = $contact;
		$this->email = $email;
		$this->account = $account;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$email = $this->email;
		$contact = $this->contact;
		$account = $this->account;

//		dd($contact->email);

		$this->subject('testando o email!!!!!!');
		$this->to($contact->email, $contact->name);

		return $this->markdown('emails.marketing', compact(
								'account',
								'email',
								'contact',
		));
	}

}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Campaign;

class Marketing extends Mailable {

	use Queueable,
	 SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($data) {
//            dd($data);
//		$this->accountName = $data->accountName;
//		$this->contactName = $data->contactName;
//		$this->contactEmail = $data->contactEmail;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$contact = $data->contactEmail;
		$account = $this->account;

		dd($contact);

		$this->subject($campaign->email->title);
		$this->to($contact->email, $contact->name);

		return $this->markdown('emails.marketing', compact(
								'account',
								'email',
								'contact',
		));
	}

}

<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactModel;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    	public function index() {
		$contacts = ContactModel::all();
		$user = Auth::user();

		return view('contacts.listAllContacts', [
			'contacts' => $contacts,
			'user' => $user,
		]);
	}
	
	public function Contact() {
		return response()->json(ContactModel::get(), 200);
	}
	
}

<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Company;
use App\Models\Opportunity;
use App\Models\User;

class ContactController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $contacts = Contact::where('account_id', auth()->user()->account_id)

//                ->where(function ($query) use ($request) {
//                    if ($request->name) {
//                        $query->where('name', 'like', "%$request->name%");
//                    }
//                })
                ->with('opportunities', 'companies', 'user')
                ->orderBy('NAME', 'ASC')
                ->paginate(20);

        $total = $contacts->total();

        return view('contacts.indexContacts', compact(
                        'contacts',
                        'total',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $states = returnStates();
        $genderTypes = Contact::returnGenderTypes();
        $hobbies = Contact::returnHobbie();
        $religions = Contact::returnReligion();
        $etinicities = Contact::returnEtinicity();
        $professions = Contact::returnProfession();
        $job_positions = Contact::returnProfession();
        $contactTypes = Contact::returnContactTypes();

        return view('contacts.createContact', compact(
                        'states',
                        'companies',
                        'genderTypes',
                        'hobbies',
                        'religions',
                        'etinicities',
                        'professions',
                        'job_positions',
                        'contactTypes',
        ));
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
                    'first_name' => 'required:tasks',
                    'last_name' => 'required:tasks',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $contact->account_id = auth()->user()->account_id;
            $contact->save();
            $contact->companies()->sync($request->companies);
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

        return view('contacts.showContact', [
            'contact' => $contact,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact) {
        $companies = Company::where('account_id', auth()->user()->account_id)
                ->get();

        $companiesChecked = Company::whereHas('contacts', function ($query) use ($contact) {
                    $query->where('contact_id', $contact->id);
                })
                ->pluck('id')
                ->toArray();

        $states = returnStates();
        $genderTypes = Contact::returnGenderTypes();
        $hobbies = Contact::returnHobbie();
        $religions = Contact::returnReligion();
        $etinicities = Contact::returnEtinicity();
        $professions = Contact::returnProfession();
        $job_positions = Contact::returnProfession();
        $contactTypes = Contact::returnContactTypes();

        return view('contacts.editContact', compact(
                        'contact',
                        'companies',
                        'companiesChecked',
                        'states',
                        'genderTypes',
                        'hobbies',
                        'religions',
                        'etinicities',
                        'professions',
                        'job_positions',
                        'contactTypes',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact) {
        $contact->fill($request->all());
        $contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);
        $contact->save();
        $contact->companies()->sync($request->companies);

        return view('contacts.showContact', [
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

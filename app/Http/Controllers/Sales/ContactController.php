<?php

namespace App\Http\Controllers\Sales;

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
use App\Http\Traits\FilterModelTrait;

class ContactController extends Controller {

    use FilterModelTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $contacts = Contact::filterModel($request);
        $total = $contacts->total();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $types = Contact::returnContactTypes();

        return view('sales.contacts.index', compact(
                        'contacts',
                        'total',
                        'companies',
                        'types',
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

        $leadSources = Contact::returnSources();
        $states = returnStates();
        $genderTypes = Contact::returnGenderTypes();
        $hobbies = Contact::returnHobbie();
        $religions = Contact::returnReligion();
        $etinicities = Contact::returnEtinicity();
        $professions = Contact::returnProfessions();
        $jobPositions = Contact::returnProfessions();
        $contactTypes = Contact::returnContactTypes();

        return view('sales.contacts.create', compact(
                        'leadSources',
                        'states',
                        'companies',
                        'genderTypes',
                        'hobbies',
                        'religions',
                        'etinicities',
                        'professions',
                        'jobPositions',
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

        return redirect()->action('Sales\\ContactController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact) {

        return view('sales.contacts.show', [
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
        $professions = Contact::returnProfessions();
        $job_positions = Contact::returnProfessions();
        $contactTypes = Contact::returnContactTypes();

        return view('sales.contacts.edit', compact(
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

        return view('sales.contacts.show', [
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

    public function targetAudience() {
        $contacts = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'cliente')
                ->orderBy('name', 'ASC')
                ->get();

        $totalContacts = $contacts->count();

//        $opportunitiesWon = Opportunity::where('account_id', auth()->user()->account_id)
//                ->where('status', 'ganhamos')
//                ->with('contact')
//                ->get();

        $clients = Contact::whereHas('opportunities', function ($query) {
                    $query->where('account_id', auth()->user()->account_id);
                    $query->where('status', 'ganhamos');
                })
                ->orderBy('name', 'ASC')
                ->get();

        $totalClients = $clients->count();

        // TOTAL
        $sourcesTotals = Contact::totalAndPercentage('lead_source', Contact::returnSources());
        $professionsTotals = Contact::totalAndPercentage('profession', Contact::returnProfessions());
        $etinicityTotals = Contact::totalAndPercentage('etinicity', Contact::returnEtinicity());
        $religionTotals = Contact::totalAndPercentage('religion', Contact::returnReligion());
        $genderTypesTotals = Contact::totalAndPercentage('gender', Contact::returnGenderTypes());
        $hobbiesTotals = Contact::totalAndPercentage('hobbie', Contact::returnHobbie());

        // WON
        $sourcesWon = Contact::totalAndPercentageWon('lead_source', Contact::returnSources());
        $professionsWon = Contact::totalAndPercentageWon('profession', Contact::returnProfessions());
        $etinicityWon = Contact::totalAndPercentageWon('etinicity', Contact::returnEtinicity());
        $religionWon = Contact::totalAndPercentageWon('religion', Contact::returnReligion());
        $genderTypesWon = Contact::totalAndPercentageWon('gender', Contact::returnGenderTypes());
        $hobbiesWon = Contact::totalAndPercentageWon('hobbie', Contact::returnHobbie());

        return view('sales.contacts.targetAudience', compact(
                        'totalContacts',
                        'totalClients',
                        'sourcesTotals',
                        'professionsTotals',
                        'etinicityTotals',
                        'religionTotals',
                        'genderTypesTotals',
                        'hobbiesTotals',
                        'sourcesWon',
                        'professionsWon',
                        'etinicityWon',
                        'religionWon',
                        'genderTypesWon',
                        'hobbiesWon',
        ));
    }
}

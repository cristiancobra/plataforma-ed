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
use App\Models\Page;
use App\Models\User;
use App\Http\Traits\FilterModelTrait;
use League\Csv\Reader;
use League\Csv\Statement;

class ContactController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $contacts = Contact::filterModel($request);
        $total = $contacts->total();

        $employees = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'funcionário')
                ->get();
        $employessTotal = $employees->count();

        $news = Contact::where('account_id', auth()->user()->account_id)
                ->get();
        $newsTotal = $news->count();

        $clients = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'cliente')
                ->get();
        $clientsTotal = $clients->count();

        $suppliers = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'fornecedor')
                ->get();
        $suppliersTotal = $suppliers->count();

        $partners = Contact::where('account_id', auth()->user()->account_id)
                ->where('type', 'parceiro')
                ->get();
        $partnersTotal = $partners->count();

        $companies = Company::where('account_id', auth()->user()->account_id)
                ->orderBy('NAME', 'ASC')
                ->get();

        $types = Contact::returnContactTypes();

        return view('sales.contacts.index', compact(
                        'contacts',
                        'total',
                        'employessTotal',
                        'newsTotal',
                        'clientsTotal',
                        'suppliersTotal',
                        'partnersTotal',
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
                    'first_name' => 'required:contact',
                    'last_name' => 'required:contact',
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
        $contact->authorization_data = $request->has('authorization_data') ? true : false;
        $contact->authorization_contact = $request->has('authorization_contact') ? true : false;
        $contact->authorization_newsletter = $request->has('authorization_newsletter') ? true : false;
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

    public function storeFromForm(Request $request, Page $page) {
        $messages = [
            'unique' => ' * :attribute já cadastrado.',
            'required' => ' *obrigatório.',
        ];
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required:contacts',
                    'authorization_data' => 'required:contacts',
                    'email' => 'unique:contacts',
                        ], $messages);

        if ($validator->fails()) {
            return back()
                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $contact = new Contact();
            $contact->fill($request->all());
//            dd($contact);
            $contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);
            $contact->account_id = $page->account_id;
            $contact->type = 'cliente';
            $contact->status = 'ativo';
            $contact->save();
//            $contact->companies()->sync($request->companies);

            return back()
                            ->with('success', 'Seus dados foram enviados com sucesso!')
                            ->withInput();
        }
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

    public function configCsv() {
        $accounts = Account::all();

        return view('sales.contacts.importCsv', compact(
                        'accounts',
        ));
    }

    public function importCsv(Request $request) {
        $path = $request->file('sheet');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setDelimiter($request->delimiter);
        $csv->setHeaderOffset(0); //set the CSV header offset

        $stmt = Statement::create()
                ->offset(0)
                ->limit(500);

        $records = $stmt->process($csv);

        $recordsTotal = $records->count();

        $account = Account::where('id', $request->account_id)
                ->first();

        return view('sales.contacts.confirmCsv', compact(
                        'request',
                        'records',
                        'account',
                        'recordsTotal',
        ));
    }

    public function storeCsv(Request $request) {
        $counter = 0;

        foreach ($request->account_id as $key => $value) {
            $counter += 1;
            $data = array(
                'account_id' => $request->account_id[$key],
                'type' => 'cliente',
                'lead_source' => 'importado',
                'first_name' => $request->first_name [$key],
                'last_name' => $request->last_name [$key],
                'email' => $request->email [$key] ?? null,
                'phone' => $request->phone [$key] ?? null,
                'address' => $request->address [$key] ?? null,
                'city' => $request->city [$key] ?? null,
                'state' => $request->state [$key] ?? null,
                'country' => $request->country [$key] ?? null,
                'zip_code' => $request->zip_code [$key] ?? null,
                'gender' => $request->gender [$key] ?? null,
                'cpf' => $request->cpf [$key] ?? null,
                'name' => ucfirst($request->first_name [$key]) . " " . ucfirst($request->last_name [$key]),
            );
            Contact::insert($data);
        }

        return redirect()->route('contact.config')->with('message', "Sucesso! Foram adicionados $counter novos contatos.");
    }

}

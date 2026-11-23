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
use App\Models\Image;
use App\Models\Opportunity;
use App\Models\Page;
use App\Models\User;
use App\Http\Requests\ContactRequest;
use App\Http\Traits\FilterModelTrait;
use League\Csv\Reader;
use League\Csv\Statement;

class ContactController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = Contact::filterModel($request);
        $total = $contacts->total();

        $totalTotal = Contact::where('account_id', auth()->user()->account_id)->count();
        $filtersActive = collect($request->except(['page', 'trash', 'role', 'filter']))
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->isNotEmpty();

        $companies = Company::companiesSelectOptions();
        $types = Contact::returnContactTypes();
        $leadSources = array_values(array_filter(Contact::returnSources()));
        $statuses = Contact::STATUSES;

        return view('sales.contacts.index', compact(
            'contacts',
            'total',
            'totalTotal',
            'filtersActive',
            'companies',
            'types',
            'leadSources',
            'statuses',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $contact = new Contact([
            'type' => $request->type,
            'status' => 'ativo',
            'country' => 'Brasil',
        ]);

        return view('sales.contacts.create', array_merge(compact('contact'), $this->formOptions()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = new Contact();
        $this->fillContact($contact, $request);
        $contact->account_id = auth()->user()->account_id;
        $contact->save();
        $contact->companies()->sync($this->accountCompanyIds($request));

        return redirect()
            ->route('contact.show', $contact)
            ->with('success', 'Contato criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $contact->load('companies', 'opportunities', 'images');

        return view('sales.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        return view('sales.contacts.edit', array_merge(compact('contact'), $this->formOptions()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->fillContact($contact, $request);
        $contact->save();
        $contact->companies()->sync($this->accountCompanyIds($request));

        return redirect()
            ->route('contact.show', $contact)
            ->with('success', 'Contato atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Contato apagado.');
    }

    /**
     * Preenche o contato com os dados validados do formulário de criar/editar.
     */
    private function fillContact(Contact $contact, ContactRequest $request)
    {
        $contact->fill(collect($request->validated())->except('companies')->all());
        $contact->name = trim(ucfirst($request->first_name) . ' ' . ucfirst((string) $request->last_name));
        $contact->authorization_data = $request->boolean('authorization_data');
        $contact->authorization_contact = $request->boolean('authorization_contact');
        $contact->authorization_newsletter = $request->boolean('authorization_newsletter');
    }

    /**
     * Opções dos selects do formulário de criar/editar.
     */
    private function formOptions()
    {
        return [
            'companies' => Company::companiesSelectOptions(),
            'states' => array_filter(returnStates()),
            'statuses' => Contact::STATUSES,
            'genderTypes' => array_values(array_filter(Contact::returnGenderTypes())),
            'hobbies' => array_values(array_filter(Contact::returnHobbie())),
            'religions' => array_values(array_filter(Contact::returnReligion())),
            'etinicities' => array_values(array_unique(array_filter(Contact::returnEtinicity()))),
            'professions' => array_values(array_filter(Contact::returnProfessions())),
            'leadSources' => array_values(array_filter(Contact::returnSources())),
            'contactTypes' => Contact::returnContactTypes(),
            'schollarities' => Contact::SCHOLLARITIES,
            'civilStates' => Contact::CIVIL_STATES,
        ];
    }

    /**
     * Ids das organizações enviadas no formulário, limitados às da conta do usuário.
     */
    private function accountCompanyIds(Request $request)
    {
        return Company::where('account_id', auth()->user()->account_id)
            ->whereIn('id', (array) $request->input('companies', []))
            ->pluck('id')
            ->toArray();
    }

    public function storeFromForm(Request $request, Page $page)
    {
        $messages = [
            'unique' => ' * :attribute já cadastrado.',
            'required' => ' *obrigatório.',
            'contact_upload_image.max' => 'A imagem selecionada não pode ser maior que  15MB.'
            //                        'image.uploaded' => 'Failed to upload an image. The image maximum size is 2MB.'
        ];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required:contacts',
            'authorization_data' => 'required:contacts',
            //                    'email' => 'unique:contacts',
            'contact_upload_image' => 'image|max:50000',
        ], $messages);

        if ($validator->fails()) {
            return back()
                ->with('failed', 'Ops... alguns campos precisam ser preenchidos.')
                ->withErrors($validator)
                ->withInput();
        } else {
            $existingContact = Contact::existingContact($page->account_id, $request->email);
            if ($existingContact == false) {
                $contact = new Contact();
                $contact->fill($request->all());
                $contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);
                $contact->account_id = $page->account_id;
                $contact->type = 'cliente';
                $contact->status = 'ativo';
                $contact->save();
                $page->contacts()->save($contact);
            }

            if ($request->file('contact_upload_image')) {
                $image = new Image();
                $image->account_id = $page->account_id;
                if ($existingContact == false) {
                    $image->contact_id = $contact->id;
                } else {
                    $image->contact_id = $existingContact->id;
                }
                $image->type = 'enviado por cliente';
                $image->name = 'Imagem enviada pelo cliente ';
                $image->status = 'revisar';
                $path = $request->file('contact_upload_image')->store('customers_images');
                $image->path = $path;
                $image->save();
            }

            return back()
                ->with('success', 'Seus dados foram enviados com sucesso!')
                ->withInput();
        }
    }

    public function targetAudience()
    {
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

    public function configCsv()
    {
        $accounts = Account::all();

        return view('sales.contacts.importCsv', compact(
            'accounts',
        ));
    }

    public function importCsv(Request $request)
    {
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

    public function storeCsv(Request $request)
    {
        $counter = 0;

        foreach ($request->account_id as $key => $value) {
            $counter += 1;
            $data = array(
                'account_id' => $request->account_id[$key],
                'type' => 'cliente',
                'lead_source' => 'importado',
                'first_name' => $request->first_name[$key],
                'last_name' => $request->last_name[$key],
                'email' => $request->email[$key] ?? null,
                'phone' => $request->phone[$key] ?? null,
                'address' => $request->address[$key] ?? null,
                'city' => $request->city[$key] ?? null,
                'state' => $request->state[$key] ?? null,
                'country' => $request->country[$key] ?? null,
                'zip_code' => $request->zip_code[$key] ?? null,
                'gender' => $request->gender[$key] ?? null,
                'cpf' => $request->cpf[$key] ?? null,
                'name' => ucfirst($request->first_name[$key]) . " " . ucfirst($request->last_name[$key]),
            );
            Contact::insert($data);
        }

        return redirect()->route('contact.config')->with('message', "Sucesso! Foram adicionados $counter novos contatos.");
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Account;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use DateTime;
use DateInterval;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
//                    'first_name' => ['required', 'string', 'max:255'],
//                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        return User::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'perfil' => 'administrador',
                    'password' => Hash::make($data['password']),
                    'grepcaptcha' => ['required', new \App\Rules\ReCAPTCHAv3],
        ]);
    }

    public function register(Request $request) {
        // USUÁRIO: cria nova CONTA 
        $account = new Account();
        $account->name = $request->account_name;
        $account->email = $request->email;
        $today = new Datetime('now');
        $dueDate = $today->add(new DateInterval('P30D'));
        $account->due_date = $dueDate->format('Y-m-d');
        $account->save();

        // verifica se o nome  da  CONTA do usuário existe em COMPANIES da EMPRESA DIGITAL. Se não existir, deve, criar.
        $nameChecked = Company::where('name', 'LIKE', $request->account_name)
                ->first();
        if (!$nameChecked) {
            $companyEd = new Company();
            $companyEd->account_id = 1;
            $companyEd->type = 'cliente';
            $companyEd->name = $request->account_name;
            $companyEd->email = $request->email;
            $companyEd->save();
        }

        // USUÁRIO: cria um novo  CONTATO para o usuário criado acima
        $contact = new Contact();
        $contact->account_id = $account->id;
        $contact->type = 'funcionário';
        $contact->first_name = ucfirst($request->first_name);
        $contact->last_name = ucfirst($request->last_name);
        $contact->name = $contact->first_name . " " . $contact->last_name;
        $contact->email = $request->email;
        $contact->authorization_data = 1;
        $contact->authorization_contact = $request->authorization_contact == "on" ? 1 : 0;
        $contact->authorization_newsletter = $request->authorization_newsletter == "on" ? 1 : 0;
        $contact->save();

        // EMPRESA DIGITAL:  cria USUÁRIO com o contato criado acima
        $user = new User();
        $user->contact_id = $contact->id;
        $user->perfil = 'dono';
        $user->email = $request->email;
//        $user->default_password = $request->password;
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->account_id = $account->id;
        $today = new Datetime('now');
        $today->add(new DateInterval('P1M'));
        $user->save();

//        EMPRESA DIGITAL:  cria novo CONTATO se o email fornecido existe nos CONTATOS da EMPRESA DIGITAL
        $emailChecked = Contact::where('email', $request->email)
                ->where('account_id')
                ->first();
        if (!$emailChecked) {
            $contactEd = new Contact();
            $contactEd->account_id = 1;
            $contactEd->lead_source = 'site';
            $contactEd->type = 'cliente';
            $contactEd->first_name = ucfirst($request->first_name);
            $contactEd->last_name = ucfirst($request->last_name);
            $contactEd->name = $contact->first_name . " " . $contact->last_name;
            $contactEd->email = $request->email;
            $contactEd->authorization_data = 1;
            $contactEd->authorization_contact = $request->authorization_contact == "on" ? 1 : 0;
            $contactEd->authorization_newsletter = $request->authorization_newsletter == "on" ? 1 : 0;
            $contactEd->save();
            $contactEd->companies()->attach($contactEd->id);
        }

//        EMPRESA DIGITAL:  cria uma nova OPORTUNIDADE se o cadastro autorizar que entre em contato
        if ($contactEd->authorization_contact == 1) {
            $opportunityEd = new Opportunity();
            $opportunityEd->name = "$contactEd->name cadastro do site";
            $opportunityEd->account_id = 1;
            $opportunityEd->user_id = 2;

            if (!$nameChecked) {
                $opportunityEd->company_id = $companyEd->id;
            } else {
                $opportunityEd->company_id = $nameChecked->id;
            }

            $opportunityEd->contact_id = $contactEd->id;
            $opportunityEd->date_start = date('Y-m-d');
            $opportunityEd->stage = 'apresentação';
            $opportunityEd->status = 'negociando';
            $opportunityEd->save();

//        EMPRESA DIGITAL:  cria uma nova TAREFA  para entrar em contato com a OPORTUNIDADE criada acima
            $taskOpportunity = new Task();
            $taskOpportunity->name = "Fazer primeiro contato com $contactEd->name";
            $taskOpportunity->account_id = 1;
            $taskOpportunity->contact_id = $contactEd->id;
            $taskOpportunity->user_id = 2;
            $taskOpportunity->department = 'vendas';
            $taskOpportunity->opportunity_id = $opportunityEd->id;
            $taskOpportunity->date_start = date('Y-m-d');
            $today = new Datetime('now');
            $today->add(new DateInterval('P2D'));
            $taskOpportunity->date_due = $today;

            if (!$nameChecked) {
                $taskOpportunity->company_id = $companyEd->id;
            } else {
                $taskOpportunity->company_id = $nameChecked->id;
            }

            $taskOpportunity->priority = 'alta';
            $taskOpportunity->status = 'fazer';
            $taskOpportunity->save();
        }

        return redirect('/');
    }

    function createContact($user) {
        $contact = new Contact();
        $contact->fill($request->all());
        $contact->name = ucfirst($request->first_name) . " " . ucfirst($request->last_name);

//        $messages = [
//            'unique' => 'Já existe um contato com este :attribute.',
//            'required' => '*preenchimento obrigatório.',
//        ];
//        $validator = Validator::make($request->all(), [
//                    'first_name' => 'required:tasks',
//                    'last_name' => 'required:tasks',
//                        ], $messages);
//
//        if ($validator->fails()) {
//            return back()
//                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
//                            ->withErrors($validator)
//                            ->withInput();
//        } else {
        $contact->save();
//            $contact->companies()->sync($request->companies);
    }

}

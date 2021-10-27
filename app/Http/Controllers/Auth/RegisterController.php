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
        $empresaDigital = Account::find(1);
        
        // Cria uma CONTA, USUÁRIO e CONTATO para o novo registro
        $account = Account::registerAccount($request);
        $contact = Contact::registerContact($request, $account->id);
        $user = User::registerUser($request, $contact->id, $account->id);
        $companyEdCustomer = Company::registerCompanyEdCustomer($account, $empresaDigital);
        $contactEdCustomer = Contact::registerContactEdCustomer($account, $empresaDigital, $companyEdCustomer);

//  Cria novo CONTATO, EMPRESA, OPORTUNIDADE e TAREFA DA OPORTUNIDADE na EMPRESA DIGITAL
        $contactEd = Contact::registerContactEd($request);
        $companyEd = Company::registerCompanyEd($request);
        $opportunityEd = Opportunity::registerOpportunityEd($contactEd, $companyEd);

        if ($opportunityEd) {
            $taskOpportunity = Task::registerTaskOpportunity($contactEd, $companyEd, $opportunityEd);
        }
        
        $systemTextsTutorials = SystemTask::where('type', 'primeiros passos')
                ->where('status', 'ativada')
                ->get();
        
        foreach($systemTextsTutorials as $systemText) {
            SystemText::registerTasksTutorials($systemText, $user, $companyEdCustomer, $contact, $account, $contactEdCustomer);
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

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
        ]);
    }

    public function register(Request $request) {
        $account = new Account();
        $account->name = $request->account_name;
        $account->email = $request->email;
        $account->save();

        $contact = new Contact();
        $contact->account_id = $account->id;
        $contact->first_name = ucfirst($request->first_name);
        $contact->last_name = ucfirst($request->last_name);
        $contact->name = $contact->first_name . " " . $contact->last_name;
        $contact->email = $request->email;
        $contact->save();

        $user = new User();
        $user->contact_id = $contact->id;
        $user->perfil = $request->perfil;
        $user->email = $request->email;
//        $user->default_password = $request->password;
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->account_id = $account->id;
        $user->save();
        $user->accounts()->sync($account->id);

//        $messages = [
//            'required' => '*preenchimento obrigatório.',
//            'unique' => '*já existe um usuário cadastrado com este email.',
//        ];
//        $validator = Validator::make($request->all(), [
//                    'email' => 'required|unique:users',
//                    'password' => 'required:users',
//                        ],
//                        $messages);
//
//        if ($validator->fails()) {
//            return back()
//                            ->with('failed', 'Ops... alguns campos precisam ser preenchidos corretamente.')
//                            ->withErrors($validator)
//                            ->withInput();
//        } else {
//        dd($user);
//            $user->save();
        //        $this->createContact($user);
        return redirect('/');
    }

    public function createContact($user) {
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
